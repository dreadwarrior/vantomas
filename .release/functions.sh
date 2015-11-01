#!/bin/bash

# -----------------------------------------------------------------------------
# Parse simple yaml files
#
# @see http://stackoverflow.com/a/21189044
#
# @param 1: YAML file to parse
# @param 2: prefix for parsed variables
#
# @return string
# -----------------------------------------------------------------------------
parse_yaml() {
   local prefix=$2
   local s='[[:space:]]*' w='[a-zA-Z0-9_]*' fs=$(echo @|tr @ '\034')
   sed -ne "s|^\($s\):|\1|" \
        -e "s|^\($s\)\($w\)$s:$s[\"']\(.*\)[\"']$s\$|\1$fs\2$fs\3|p" \
        -e "s|^\($s\)\($w\)$s:$s\(.*\)$s\$|\1$fs\2$fs\3|p"  $1 |
   awk -F$fs '{
      indent = length($1)/2;
      vname[indent] = $2;
      for (i in vname) {if (i > indent) {delete vname[i]}}
      if (length($3) > 0) {
         vn=""; for (i=0; i<indent; i++) {vn=(vn)(vname[i])("_")}
         printf("%s%s%s=\"%s\"\n", "'$prefix'",vn, $2, $3);
      }
   }'
}

# -----------------------------------------------------------------------------
# Set release tool variables from secret ansible group_vars file.
#
# @param 1: group name
#
# @return void
# -----------------------------------------------------------------------------
set_releasetool_variables_from_secret_ansible_groupvars_file() {
  local group=$1

  fn_dialog_info "Reading secret group_vars..."

  eval $(parse_yaml ${PROJECTPATH}/.ansible/playbooks/group_vars/${group}/secrets.yml "SECRET_")


  SSHUSER=$SECRET_release_ssh_user
  SSHHOST=$SECRET_release_ssh_host
  SSHPORT=$SECRET_release_ssh_port

  MYSQL_HOST_REMOTE=$SECRET_release_database_remote_host
  MYSQL_USERNAME_REMOTE=$SECRET_release_database_remote_username
  MYSQL_PASSWORD_REMOTE=$SECRET_release_database_remote_password
  MYSQL_DB_REMOTE=$SECRET_release_database_remote_name

  REMOTEPATH=$SECRET_release_path

  if [ $FORCE = 0 ]; then
    function_summary
  fi
}

# -----------------------------------------------------------------------------
# Get secret ansible group_vars file of a specific group.
#
# Copies a secret ansible group_vars file from the project directory into the
# build directory.
#
# @param 1: group name
#
# @return void
# -----------------------------------------------------------------------------
get_secret_ansible_groupvars_file_of_group() {
  local group=$1

  local secrets_path=".ansible/playbooks/group_vars/${group}"
  local secrets_src="${PROJECTPATH}/${secrets_path}/secrets.yml"
  local secrets_dst="${secrets_path}/"

  fn_dialog_waitingbox "cp -f ${secrets_src} ${secrets_dst}" \
                       "Copy secret group_vars file..."
}

# -----------------------------------------------------------------------------
# Run the ansible build playbook for a specific group.
#
# @param 1: group name
#
# @return void
# -----------------------------------------------------------------------------
run_ansible_build_playbook_on_group() {
  local group=$1

  local working_dir=`pwd`
  local ansible_opt="--limit ${group} --extra-vars \"working_dir=${working_dir} grunt_build_environment=${group}\""

  fn_dialog_progressbox "ansible-playbook ${ansible_opt} .ansible/playbooks/build.yml" \
                        "Execute ansible build playbook..."
}

# -----------------------------------------------------------------------------
# Replace a version placeholder in a specific file with a version string
#
# @param 1: file path, defaults to "web/typo3conf/ext/vantomas/Configuration/TypoScript/Page/Site/setup.txt"
# @param 2: placeholder string, defaults to "@version@"
#
# @return void
# -----------------------------------------------------------------------------
replace_version_placeholder() {
  local file="${1:-web/typo3conf/ext/vantomas/Configuration/TypoScript/Page/Site/setup.txt}"
  local placeholder="${2:-@version@}"
  local version=`git rev-parse HEAD`

  fn_dialog_progressbox "sed -i 's/${placeholder}/${version}/' ${file}" \
                       "Replace the version placeholder ${placeholder} in ${file}"
}

# -----------------------------------------------------------------------------
# Create user data directories on the remote host.
#
# @return void
# -----------------------------------------------------------------------------
create_remote_userdata_directories() {
  local ssh_args="-p ${SSHPORT} ${SSHUSER}@${SSHHOST}"

  local dirs="${REMOTEPATH}/web/fileadmin/user_upload/_temp_"
  local dirs="${dirs} ${REMOTEPATH}/web/typo3conf/l10n"
  local dirs="${dirs} ${REMOTEPATH}/web/typo3temp/llxml"
  local dirs="${dirs} ${REMOTEPATH}/web/uploads/media"
  local dirs="${dirs} ${REMOTEPATH}/web/uploads/pics"
  local dirs="${dirs} ${REMOTEPATH}/web/uploads/tf"

  fn_dialog_progressbox "ssh ${ssh_args} 'mkdir -p ${dirs}'" \
                        "Create user data directories"
}

# -----------------------------------------------------------------------------
# Create index.html files on the remote host to prevent directory listing.
#
# @return void
# -----------------------------------------------------------------------------
create_remote_directory_indexes() {
  local ssh_args="-p ${SSHPORT} ${SSHUSER}@${SSHHOST}"

  local files="${REMOTEPATH}/web/fileadmin/user_upload/index.html"
  local files="${files} ${REMOTEPATH}/web/fileadmin/user_upload/_temp_/index.html"
  local files="${files} ${REMOTEPATH}/web/typo3temp/index.html"
  local files="${files} ${REMOTEPATH}/web/uploads/media/index.html"
  local files="${files} ${REMOTEPATH}/web/uploads/pics/index.html"
  local files="${files} ${REMOTEPATH}/web/uploads/tf/index.html"

  fn_dialog_progressbox "ssh ${ssh_args} 'touch ${files}'" \
                        "Create index.html files to prevent directory listing"
}

# -----------------------------------------------------------------------------
# Clears the remote TYPO3.CMS cache.
#
# @return void
# -----------------------------------------------------------------------------
clear_remote_typo3_cache() {
  local ssh_args="-p ${SSHPORT} ${SSHUSER}@${SSHHOST}"
  local mysql_args="-u${MYSQL_USERNAME_REMOTE} -p${MYSQL_PASSWORD_REMOTE} ${MYSQL_DB_REMOTE}"

  local paths="web/typo3temp/Cache/Code/*"

  local queries="TRUNCATE TABLE cf_extbase_reflection; TRUNCATE TABLE cf_extbase_reflection_tags;"
  local queries="${queries} TRUNCATE TABLE cf_extbase_object; TRUNCATE TABLE cf_extbase_object_tags;"

  fn_dialog_yesorno "Clear TYPO3.CMS code cache on remote machine? (Y/n)"

  if [ "$RETURN" = "1" ]; then
    fn_dialog_progressbox "ssh ${ssh_args} 'cd ${REMOTEPATH} && rm -rf ${paths}'" \
                          "Remove cache files"

    fn_dialog_progressbox "ssh ${ssh_args} 'mysql ${mysql_args} -e \"${queries}\"'"
  fi
}

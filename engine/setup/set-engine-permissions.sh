#!/bin/bash

# ispCP ω (OMEGA) a Virtual Hosting Control Panel
# Copyright (c) 2001-2006 by moleSoftware GmbH
# http://www.molesoftware.com
# Copyright (c) 2006-2008 by isp Control Panel
# http://isp-control.net
#
#
# License:
#    This program is free software; you can redistribute it and/or
#    modify it under the terms of the MPL Mozilla Public License
#    as published by the Free Software Foundation; either version 1.1
#    of the License, or (at your option) any later version.
#
#    This program is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    MPL Mozilla Public License for more details.
#
#    You may have received a copy of the MPL Mozilla Public License
#    along with this program.
#
#    An on-line copy of the MPL Mozilla Public License can be found
#    http://www.mozilla.org/MPL/MPL-1.1.html
#
#
# The ispCP ω Home Page is at:
#
#    http://isp-control.net
#

# for activating debug, please set to 1;
DEBUG=0

# read needed entries from ispcp.conf
if [ -f /usr/local/etc/ispcp/ispcp.conf ]
then
	for a in `cat /usr/local/etc/ispcp/ispcp.conf | grep -E '(APACHE_|ROOT_|MTA_MAILBOX_|^LOG_DIR)' | sed -e 's/ //g'`; do
		export $a
	done
else
	for a in `cat /etc/ispcp/ispcp.conf | grep -E '(APACHE_|ROOT_|MTA_MAILBOX_|^LOG_DIR)' | sed -e 's/ //g'`; do
		export $a
	done
fi

#
# fixing engine permissions;
#

echo -n "	Setting Engine Permissions: ";

if [ $DEBUG -eq 1 ]; then
    echo	"";
fi

# Fix ispcp.conf perms
if [ $DEBUG -eq 1 ]; then
    echo -e "	ug+r,u+w,o-r $ROOT_USER:$APACHE_SUEXEC_USER_PREF$APACHE_SUEXEC_MIN_UID /etc/ispcp/ispcp.conf";
else
    echo -n ".";
fi

#chmod ug+r,u+w,o-r /etc/ispcp/ispcp.conf
if [ -f /usr/local/etc/ispcp/ispcp.conf ]
then
	chown $ROOT_USER:$APACHE_SUEXEC_USER_PREF$APACHE_SUEXEC_MIN_UID /usr/local/etc/ispcp/ispcp.conf
else
	chown $ROOT_USER:$APACHE_SUEXEC_USER_PREF$APACHE_SUEXEC_MIN_UID /etc/ispcp/ispcp.conf
fi

for i in `find $ROOT_DIR/engine/`; do

	if [ -f $i ]; then

		if [ $DEBUG -eq 1 ]; then
			echo -e "	0700 $ROOT_USER:$ROOT_GROUP $i";
		fi

		chmod 0700 $i;
		chown $ROOT_USER:$ROOT_GROUP $i;

	elif [ -d $i ]; then

		if [ $DEBUG -eq 1 ]; then
			echo "0700 $ROOT_USER:$ROOT_GROUP [$i]";
		else
			echo -n ".";
		fi

		chmod 0700 $i;
		chown $ROOT_USER:$ROOT_GROUP $i;
	fi

done

#
# fixing engine folder permissions;
#

		chmod 0755 $ROOT_DIR/engine;
		chown $ROOT_USER:$ROOT_GROUP $ROOT_DIR/engine;

#
# fixing messager permissions;
#

i="$ROOT_DIR/engine/messager"

if [ $DEBUG -eq 1 ]; then
	echo "0700 $MTA_MAILBOX_UID_NAME:$MTA_MAILBOX_GID_NAME [$i]";
else
	echo -n ".";
fi

		chmod -R 0700 $i;
		chown -R $MTA_MAILBOX_UID_NAME:$MTA_MAILBOX_GID_NAME $i;


#
# fixing messager folder permissions;
#

i="$ROOT_DIR/engine/messager"

if [ $DEBUG -eq 1 ]; then
	echo "0755 $ROOT_USER:$ROOT_GROUP folder [$i]";
else
	echo -n ".";
fi


		chmod 0755 $i;
		chown $ROOT_USER:$ROOT_GROUP $i;


#
# fixing messager log folder permissions;
#

i="${LOG_DIR}/ispcp-arpl-msgr"

if [ $DEBUG -eq 1 ]; then
	echo "0755 $MTA_MAILBOX_UID_NAME:$MTA_MAILBOX_GID_NAME folder [$i]";
else
	echo -n ".";
fi

		chmod 0755 $i;
		chown -R $MTA_MAILBOX_UID_NAME:$MTA_MAILBOX_GID_NAME $i;

echo "done";

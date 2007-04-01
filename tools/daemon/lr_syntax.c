#include <errno.h>
#include <sys/types.h>
#include <sys/stat.h>
#include <fcntl.h>
#include <sys/param.h>

#if defined(__OpenBSD__) || defined(__FreeBSD__)
#include <sys/proc.h>
#else
#include <sys/procfs.h>
#endif

#include <unistd.h>
#include "lr_syntax.h"

#if !defined(__OpenBSD__) && !defined(__FreeBSD__)
int readlink(char *pathname, char *buf, int bufsize);
#endif

int lr_syntax(int fd, license_data_type *ld, char *buff)
{

	char *ptr;

	char *ptr1;

	time_t tim;

	ptr = strstr(buff, message(MSG_LS_CMD));
	ptr1 = strstr(buff, message(MSG_EQ_CMD));

	if (ptr != buff && ptr1 != buff) {

		if (send_line(fd, message(MSG_BAD_SYNTAX), strlen(message(MSG_BAD_SYNTAX))) < 0) {

			return (-1);

		}

		return (1);

	} else {

		char *lr_ans = calloc(MAX_MSG_SIZE, sizeof(char));

		if (ptr1 == buff) {
			#if !defined(__OpenBSD__) && !defined(__FreeBSD__)
			char fname1[MAXPATHLEN];
			char fname2[MAXPATHLEN];
			char daemon_path[MAXPATHLEN];
			#endif
			/*
			 execute query:
			 chek do we have license status
			 if we have it - execute query and send ok
			 else send ERROR
			 */

			if (fork() == 0 ) {

				 int fdres, dupres;
				 char logfile[MAXPATHLEN];

				/*
				 execute it
				 */

				close(fd);

				tim = time(NULL);

				/*
				 make command with timestamps
				 */
				#if !defined(__OpenBSD__) && !defined(__FreeBSD__)
				sprintf (fname1, "/proc/%ld/exe", (long int) getpid());
				memset (fname2, 0, sizeof (fname2));
				if (readlink (fname1, fname2, sizeof (fname2)) > 0) {
					strncpy(daemon_path, fname2, strlen(fname2)-strlen("daemon/vhcs2_daemon"));
					strcat(daemon_path, "engine/vhcs2-rqst-mngr");

					fdres = open ( "/dev/null", O_RDONLY );
                                        if(fdres == -1)
                                        {
                                                say("Error in reopening stdin: %s",  strerror(errno) );
                                                exit(128);
                                        }
                                        dupres = dup2(fdres, 0); /* reassign 0*/
                                        if( dupres == -1)
                                        {
                                                say("Error in reassigning stdin: %s",  strerror(errno) );
                                                exit(128);
                                        }
                                        else if( dupres != fdres) close (fdres);

                                        memset(logfile, 0, sizeof (logfile));
                                        sprintf(logfile, "%s.%ld", LOG_DIR"/"STDOUT_LOG , (long int) tim);
                                        fdres = creat( logfile, S_IRUSR | S_IWUSR );
                                        if(fdres == -1)
                                        {
                                                say("Error in opening stdout: %s",  strerror(errno) );
                                                exit(128);
                                        }
                                        dupres = dup2(fdres, 0); /* reassign 0*/
                                        if( dupres == -1)
                                        {
					 say("Error in reassigning stdout: %s",  strerror(errno) );
                                                exit(128);
                                        }
                                        else if( dupres != fdres) close (fdres);

                                        memset(logfile, 0, sizeof (logfile));
                                        sprintf(logfile, "%s.%ld", LOG_DIR"/"STDERR_LOG , (long int) tim);
                                        fdres = creat( logfile,  S_IRUSR | S_IWUSR );
                                        if(fdres == -1)
                                        {
                                                say("Error in opening stderr: %s",  strerror(errno) );
                                                exit(128);
                                        }
                                        dupres = dup2(fdres, 0); /* reassign 0*/
                                        if( dupres == -1)
                                        {
                                                say("Error in reassigning stderr: %s",  strerror(errno) );
                                                exit(128);
                                        }
                                        else if( dupres != fdres) close (fdres);

                                        execl( daemon_path, "vhcs2-rqst-mngr" ,(char*)NULL );
					#endif

					exit(0);
				#if !defined(__OpenBSD__) && !defined(__FreeBSD__)
				}
				#endif
			}

			strcat(lr_ans, message(MSG_CMD_OK));
			strcat(lr_ans, " query scheduled for execution.\r\n");

			if (send_line(fd, lr_ans, strlen(lr_ans)) < 0) {

				free(lr_ans);

				return (-1);

			}

		}

	}

	return (NO_ERROR);

}


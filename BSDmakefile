#!/usr/bin/make -f

.ifdef $(OSTYPE)==FreeBSD
.include <Makefile.fbsd>
.else
.include <Makefile.inc>
.endif

install:
	cd ./tools && $(MAKE) install
	$(SYSTEM_MAKE_DIRS) $(SYSTEM_CONF)
	$(SYSTEM_MAKE_DIRS) $(SYSTEM_ROOT)
	$(SYSTEM_MAKE_DIRS) $(SYSTEM_LOG)
	$(SYSTEM_MAKE_DIRS) $(SYSTEM_LOG)/ispcp-arpl-msgr
	$(SYSTEM_MAKE_DIRS) $(SYSTEM_VIRTUAL)
	$(SYSTEM_MAKE_DIRS) $(SYSTEM_FCGI)
	$(SYSTEM_MAKE_DIRS) $(SYSTEM_MAIL_VIRTUAL)
	$(SYSTEM_MAKE_DIRS) $(SYSTEM_APACHE_BACK_LOG)
	cd ./configs && $(MAKE) install
	cd ./engine && $(MAKE) install
	cd ./gui && $(MAKE) install
	cd ./keys && $(MAKE) install
	cd ${INST_PREF} && cp -R * /
	rm -rf ${INST_PREF}


uninstall:
	cd ./tools && $(MAKE) uninstall
	cd ./configs && $(MAKE) uninstall
	cd ./engine && $(MAKE) uninstall
	cd ./gui && $(MAKE) uninstall
	cd ./keys && $(MAKE) uninstall
	rm -rf $(SYSTEM_CONF)
	rm -rf $(SYSTEM_ROOT)
	rm -rf $(SYSTEM_LOG)
	rm -rf $(SYSTEM_VIRTUAL)
	rm -rf $(SYSTEM_FCGI)
	rm -rf $(SYSTEM_MAIL_VIRTUAL)
	rm -rf $(SYSTEM_APACHE_BACK_LOG)
	rm -rf ./*~

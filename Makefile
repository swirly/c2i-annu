#!/usr/bin/make -f
# Makefile for c2i-annu

install:
	# Install c2i-annu web interface
	install -d $(DESTDIR)/usr/share/c2i-annu/
	cp -R web $(DESTDIR)/usr/share/c2i-annu/
	chown -R root:www-data $(DESTDIR)/usr/share/c2i-annu/web
	install -g www-data -o www-data -d $(DESTDIR)/var/lib/c2i-annu/templates_c
	install -g www-data -o www-data -d $(DESTDIR)/var/lib/c2i-annu/cache

.PHONY: install

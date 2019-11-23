FROM php:fpm-alpine

WORKDIR /usr/src
RUN chown -R www-data:root /usr/src


###############################################################################
##  PYTHON  ##
# vvvvvvvvvv #

# This hack is widely applied to avoid python printing issues in docker containers.
# See: https://github.com/Docker-Hub-frolvlad/docker-alpine-python3/pull/13
ENV PYTHONUNBUFFERED=1

# install python3 and pip3
RUN echo -e "\033[0;32m**** install python ****\033[0m" && \
    # python3-dev instead of python3 due to Python.h is necessary 
    #   to build domain-connect-dyndns
    apk add --no-cache python3-dev && \
    if [ ! -e /usr/bin/python ]; then ln -sf python3 /usr/bin/python ; fi && \
    \
    echo -e "\033[0;32m**** install pip ****\033[0m" && \
    python3 -m ensurepip && \
    rm -r /usr/lib/python*/ensurepip && \
    pip3 install --no-cache --upgrade pip setuptools wheel && \
    if [ ! -e /usr/bin/pip ]; then ln -s pip3 /usr/bin/pip ; fi

# install domain-connect-dyndns
RUN echo -e "\033[0;32m**** install domain-connect-dyndns ****\033[0m" && \
    apk add --no-cache build-base libffi-dev libressl-dev git && \
    pip install git+https://github.com/HeinrichAD/DomainConnectDDNS-Python.git


###############################################################################
##  PHP  ##
# vvvvvvv #

# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

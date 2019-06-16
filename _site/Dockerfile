FROM ubuntu:18.04

WORKDIR /srv/jekyll

RUN apt update -y && \
	apt install -y ruby-dev gcc make curl libc-dev libffi-dev libxml2-dev libgcrypt-dev libxslt-dev python git

RUN gem update --system

RUN bundle install

EXPOSE 4000
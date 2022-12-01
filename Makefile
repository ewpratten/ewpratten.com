
static/dist: static/dist/line-awesome/fonts static/dist/github-markdown-css/github-markdown-light.css

static/dist/line-awesome/fonts: node_modules/line-awesome/dist/line-awesome/fonts
	mkdir -p $@
	cp -r $</* $@

static/dist/github-markdown-css/github-markdown-light.css: node_modules/github-markdown-css/github-markdown-light.css
	@mkdir -p $(dir $@)
	cp $< $@

node_modules:
	npm install

public: sass content static static/dist templates jsonld_templates config.toml
	zola build
	cp -r static/dist public/dist
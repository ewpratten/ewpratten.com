


static/dist: static/dist/line-awesome static/dist/github-markdown-css/github-markdown-light.css

static/dist/line-awesome: static/dist/line-awesome/fonts/la-solid-900.woff static/dist/line-awesome/fonts/la-brands-400.woff

static/dist/line-awesome/fonts/la-solid-900.woff: node_modules/line-awesome/dist/line-awesome/fonts/la-solid-900.woff
	@mkdir -p $(dir $@)
	cp $< $@

static/dist/line-awesome/fonts/la-brands-400.woff: node_modules/line-awesome/dist/line-awesome/fonts/la-brands-400.woff
	@mkdir -p $(dir $@)
	cp $< $@

static/dist/github-markdown-css/github-markdown-light.css: node_modules/github-markdown-css/github-markdown-light.css
	@mkdir -p $(dir $@)
	cp $< $@

node_modules:
	npm install

public: sass content static static/dist templates jsonld_templates config.toml
	zola build
	cp -r static/dist public/dist
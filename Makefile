
static/dist: static/dist/line-awesome/svg static/dist/github-markdown-css/github-markdown-light.css static/dist/line-awesome/fonts/la-solid-900.woff2

static/dist/line-awesome/svg: static/dist/line-awesome/svg/envelope.svg static/dist/line-awesome/svg/github.svg static/dist/line-awesome/svg/linkedin.svg static/dist/line-awesome/svg/ellipsis-h-solid.svg

static/dist/line-awesome/svg/envelope.svg: node_modules/line-awesome/svg/envelope.svg
	mkdir -p $(dir $@)
	cp $< $@

static/dist/line-awesome/svg/github.svg: node_modules/line-awesome/svg/github.svg
	mkdir -p $(dir $@)
	cp $< $@

static/dist/line-awesome/svg/linkedin.svg: node_modules/line-awesome/svg/linkedin.svg
	mkdir -p $(dir $@)
	cp $< $@

static/dist/line-awesome/fonts/la-solid-900.woff2: node_modules/line-awesome/dist/line-awesome/fonts/la-solid-900.woff2
	mkdir -p $(dir $@)
	cp $< $@

static/dist/github-markdown-css/github-markdown-light.css: node_modules/github-markdown-css/github-markdown-light.css
	@mkdir -p $(dir $@)
	cp $< $@

static/dist/line-awesome/svg/ellipsis-h-solid.svg: node_modules/line-awesome/svg/ellipsis-h-solid.svg
	mkdir -p $(dir $@)
	cp $< $@

node_modules:
	npm install

public: sass content static static/dist templates jsonld_templates config.toml
	zola build
	cp -r static/dist public/dist
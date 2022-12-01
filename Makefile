
static/dist/line-awesome: static/dist/line-awesome/fonts/la-solid-900.woff static/dist/line-awesome/fonts/la-brands-400.woff

static/dist/line-awesome/fonts/la-solid-900.woff: node_modules/line-awesome/dist/line-awesome/fonts/la-solid-900.woff
	@mkdir -p $(dir $@)
	cp $< $@

static/dist/line-awesome/fonts/la-brands-400.woff: node_modules/line-awesome/dist/line-awesome/fonts/la-brands-400.woff
	@mkdir -p $(dir $@)
	cp $< $@
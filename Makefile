
# Buildsystem tool paths
TOOL_BLOGC = target/debug/blogc

.PHONY: all clean

all: build/intermediary/blog

clean: 
	rm -rf build

# This rule builds a single blog post into an intermediary file
build/intermediary/blog/%.json: data/blog/*/%.md
	$(TOOL_BLOGC) $< $@ 

# This rule will auto-build all intermediary blog files
ALL_INTERMEDIARY  = $(patsubst data/blog/2017/%.md, build/intermediary/blog/%.json, $(wildcard data/blog/*/*.md))
ALL_INTERMEDIARY += $(patsubst data/blog/2018/%.md, build/intermediary/blog/%.json, $(wildcard data/blog/*/*.md))
ALL_INTERMEDIARY += $(patsubst data/blog/2019/%.md, build/intermediary/blog/%.json, $(wildcard data/blog/*/*.md))
ALL_INTERMEDIARY += $(patsubst data/blog/2020/%.md, build/intermediary/blog/%.json, $(wildcard data/blog/*/*.md))
ALL_INTERMEDIARY += $(patsubst data/blog/2021/%.md, build/intermediary/blog/%.json, $(wildcard data/blog/*/*.md))
ALL_INTERMEDIARY += $(patsubst data/blog/2022/%.md, build/intermediary/blog/%.json, $(wildcard data/blog/*/*.md))
ALL_INTERMEDIARY += $(patsubst data/blog/2023/%.md, build/intermediary/blog/%.json, $(wildcard data/blog/*/*.md))
build/intermediary/blog: $(ALL_INTERMEDIARY)
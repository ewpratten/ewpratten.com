const { MarkdownPostProcessorContext, Plugin } = require('obsidian');

module.exports = class LinkInterceptorPlugin extends Plugin {
    async onload() {
        console.log('Intercept Links plugin loaded');

        // // Register an event to handle link clicks
        // this.registerEvent(
        //     this.app.workspace.on('link-clicked',(args)=>{console.log(args);})
        // );

        // Register an event to handle opening another file through a markdown link
        this.registerEvent(
            this.app.workspace.on('file-open', (file) => {
                if (file) {
                    console.log(`File open request for: ${file.path}`);

                    // If the path starts with an `@` then it's a link to another file
                    if (file.path.startsWith('@/')) {
                        // remove the @/
                        const newLink = file.path.substring(2);
                        // open the new link
                        this.app.workspace.openLinkText(newLink, '', false);

                        // Delete the auto-created file
                        this.app.vault.delete(file);
                    }
                }
            })
        );

        // Rewrite all resolved links in the metadata cache
        this.resolveAtLinks();
        this.registerEvent(
            this.app.metadataCache.on('resolved-links', () => {
                this.resolveAtLinks();
            })
        );
        this.registerEvent(
            this.app.metadataCache.on('resolve', () => {
                this.resolveAtLinks();
            })
        );
        this.registerEvent(
            this.app.metadataCache.on('changed', () => {
                this.resolveAtLinks();
            })
        );
    }

    resolveAtLinks() {
        let unresolved_links = this.app.metadataCache.unresolvedLinks;
        let unsreolved_at_links = {};
        for (let source in unresolved_links) {
            for (let destination in unresolved_links[source]) {
                if (destination.startsWith('@')) {
                    if (!unsreolved_at_links.hasOwnProperty(source)) {
                        unsreolved_at_links[source] = {};
                    }
                    unsreolved_at_links[source][destination] = unresolved_links[source][destination];
                }
            }
        }
        console.log(`Found ${Object.keys(unsreolved_at_links).length} unresolved @ links`);

        // Resolve the links
        for (let source in unsreolved_at_links) {
            for (let destination in unsreolved_at_links[source]) {
                // remove the @/
                const newLink = destination.substring(2);

                // Add to resolvedLinks
                if (!app.metadataCache.resolvedLinks[source].hasOwnProperty(`${newLink}.md`)) {
                    app.metadataCache.resolvedLinks[source][`${newLink}.md`] = 0;
                }
                app.metadataCache.resolvedLinks[source][`${newLink}.md`] += unsreolved_at_links[source][destination];
                console.log(`Resolved @ link: ${source} -> ${newLink}`);
                console.log(app.metadataCache.resolvedLinks[source]);

                // Remove the old link
                delete unsreolved_at_links[source][destination];
                delete this.app.metadataCache.unresolvedLinks[source][destination];
            }
        }
    }

};
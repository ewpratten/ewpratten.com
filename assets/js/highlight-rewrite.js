var allCodeBlocks = document.getElementsByClassName("highlighter-rouge");

for (let element of allCodeBlocks) {
    // Look for lang data
    element.classList.forEach(clazz => {
        if (clazz.includes("language-")) {
            element.dataset.lang = clazz.substring(9);
        }
    })
}
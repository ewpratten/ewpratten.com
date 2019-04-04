function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}
  
async function transition(link){
    var content = document.getElementById("content");
    var about = document.getElementById("about");
    var all = document.getElementById("body");

    console.log(link);

    if (screen && screen.width > 600) {
        content.classList.add("fade-out");
        await sleep(300);
        about.classList.add("slide-left");
        // all.classList.add("fade-out");
        await sleep(1000);
        // content.classList.add("hidden");
    }
    
    window.location = link;
}
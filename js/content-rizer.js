async function slideup(){
    var blank = document.getElementById("blank");
    var site = document.getElementById("site");

    if (screen && screen.width > 600) {
        site.style = 'scroll-behavior: unset;';

        window.location = "#top"

        await sleep(400);
        site.style = 'scroll-behavior: smooth;';

        window.location = "#content"
        await sleep(1000);
    }
    blank.style = "display:none!important;overflow: hidden; position:fixed; ";

    console.log("slide");

    return;
}

const scrollToTop = () => {
    const c = document.documentElement.scrollTop || document.body.scrollTop;
    if (c > 0) {
      window.requestAnimationFrame(scrollToTop);
      window.scrollTo(0, c - c);
    }
  };

async function slidedown(link){
    var blank = document.getElementById("blank");
    var site = document.getElementById("site");

    if (screen && screen.width > 600) {
        blank.style = "display:block !important; ";

        site.style = 'scroll-behavior: unset !important;';
        window.location = "#content"

        await sleep(20);

        site.style = 'scroll-behavior: smooth !important;';
        scrollToTop();

        await sleep(500);
    }

    window.location = link;


    return;
}

slideup();
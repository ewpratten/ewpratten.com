async function refreshStats() {
    //get ids
    var time = document.getElementById("time");
    var gap = document.getElementById("gap");
    var id = document.getElementById("id");

    // loop
    while (true) {
        $.getJSON('https://api.retrylife.ca/devrant/info', function (data) {
            // console.log(data);
            time.innerHTML = data["time_gap"] + "s";
            id.innerHTML = data["newest_id"];
            gap.innerHTML = data["id_gap"];
        });

        await sleep(5000);
    }
}

refreshStats();
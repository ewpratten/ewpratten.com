function updateProjectWall(category) {

    // Check if all projects should be shown
    var showAll = category == "all";

    // Get the wrapper element
    var wallWrapper = document.getElementById("project-grid");

    wallWrapper.querySelectorAll(".home-project").forEach((project) => {

        // Determine if the project should be shown
        let types = project.dataset.types.split(",");
        if (showAll || types.includes(category)){
            project.classList.remove("hidden");
        } else {
            project.classList.add("hidden");
        }

    });

    // Refresh the wall
    orderProjectGrid();

}
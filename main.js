document.addEventListener('DOMContentLoaded', function () {
    const aboutMeLink = document.querySelector('a[href="#aboutMe"]');
    const expertiseLink = document.querySelector('a[href="#expertise"]');
    const achievementsLink = document.querySelector('a[href="#achievement"]');
    const projectsLink = document.querySelector('a[href="#projects"]');

    aboutMeLink.addEventListener('click', function (event) {
        event.preventDefault();
        redirectToPage('aboutMe.html'); 
    });

    expertiseLink.addEventListener('click', function (event) {
        event.preventDefault();
        redirectToPage('expertise.html');
    });

    achievementsLink.addEventListener('click', function (event) {
        event.preventDefault();
        redirectToPage('achievement.html');
    });

    projectsLink.addEventListener('click', function (event) {
        event.preventDefault();
        redirectToPage('projects.html');
    });

    function redirectToPage(page) {
        window.location.href = page;
    }
});

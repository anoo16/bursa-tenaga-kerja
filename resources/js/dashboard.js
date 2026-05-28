const menuItems = document.querySelectorAll('.menu-list li');

menuItems.forEach(item => {

    item.addEventListener('click', () => {

        menuItems.forEach(menu => {
            menu.classList.remove('active');
        });

        item.classList.add('active');

    });

});

const bookmarks = document.querySelectorAll('.job-top i');

bookmarks.forEach(bookmark => {

    bookmark.addEventListener('click', () => {

        bookmark.classList.toggle('saved');

    });

});

const topIcons = document.querySelectorAll('.topbar-right i');

topIcons.forEach(icon => {

    icon.addEventListener('mouseenter', () => {

        icon.style.transform = 'scale(1.15)';

    });

    icon.addEventListener('mouseleave', () => {

        icon.style.transform = 'scale(1)';

    });

});
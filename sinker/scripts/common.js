var isVisible = false;

$(function() {
   $('#menu_button').on('click', showMenu);
});

function showMenu() {
    console.log("come");
    if (isVisible) {
        var container = $('.popup_menu_container')
        container.fadeOut(function(){container.remove();});
    } else {
        var container = $('<div>').addClass('popup_menu_container').hide();
        var bg = $('<div>').addClass('popup_menu_bg').on('click', showMenu);;
        container.append(bg);
        container.append($('<a>').attr('href', 'index.html').append($('<div>').addClass('popup_menu_item').text('TOP')));
        container.append($('<div>').addClass('popup_menu_item').text('Story'));
        container.append($('<a>').attr('href', 'dungeons.html').append($('<div>').addClass('popup_menu_item').text('Dungeons')));
        container.append($('<div>').addClass('popup_menu_item').text('Mind Elements'));
        container.append($('<a>').attr('href', 'items.html').append($('<div>').addClass('popup_menu_item').text('Items')));
        container.append($('<a>').attr({href:'http://okumocchi.jp/blog/', target:'_blank'}).append($('<div>').addClass('popup_menu_item').text('Blog (new tab)')));

        $('body').append(container);
        container.fadeIn();

    }

    isVisible = !isVisible;
}
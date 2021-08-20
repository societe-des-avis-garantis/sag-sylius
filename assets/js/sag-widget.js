const tabTiggers = document.querySelectorAll('.tab-trigger');
Array.from(tabTiggers).forEach((tabTigger) => {
  const tabName = tabTigger.getAttribute('data-tab');

  tabTigger.addEventListener('click', function () {
    // Change tab
    $.tab('change tab', tabName);

    // Active the right tab menu
    const tabMenu = document.querySelector('.item[data-tab='+tabName+']');
    const tabMenus = tabMenu.closest('.menu');
    const tabMenuActive = tabMenus.querySelector('.item.active');
    console.log(tabMenu, tabMenus,tabMenuActive);
    tabMenuActive.classList.remove('active');
    tabMenu.classList.add('active');
  });
});

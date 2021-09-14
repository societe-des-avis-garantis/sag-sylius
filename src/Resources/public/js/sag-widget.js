const tabTriggers = document.querySelectorAll('.tab-trigger');
Array.from(tabTriggers).forEach((tabTrigger) => {
  const tabName = tabTrigger.dataset.tab;

  tabTrigger.addEventListener('click', function () {
    // Change tab
    $.tab('change tab', tabName);

    // Activate the right tab menu
    const tabMenu = document.querySelector('.item[data-tab='+tabName+']');
    const tabMenus = tabMenu.closest('.menu');
    const tabMenuActive = tabMenus.querySelector('.item.active');
    tabMenuActive.classList.remove('active');
    tabMenu.classList.add('active');
  });
});

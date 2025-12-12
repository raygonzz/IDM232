document.addEventListener('DOMContentLoaded', () => {
  const garlicLink = document.getElementById('garlic-link');
  const garlicTooltip = document.getElementById('tooltip-add');

  garlicLink.addEventListener('mouseenter', () => {
    garlicTooltip.style.opacity = '1';
    garlicTooltip.style.visibility = 'visible';
  });

  garlicLink.addEventListener('mouseleave', () => {
    garlicTooltip.style.opacity = '0';
    garlicTooltip.style.visibility = 'hidden';
  });
});
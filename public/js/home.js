const btnToggleInfo = document.querySelector('#btn-toggle-info');
const info = document.querySelector('#info');

info.classList.remove('show');

btnToggleInfo.addEventListener('click', () => {
	if (info.classList.contains('show')) btnToggleInfo.style.rotate = '0deg';
	else btnToggleInfo.style.rotate = '180deg';
	info.classList.toggle('show');
});

const mainImage = document.querySelector('.main-image img');
const images = document.querySelectorAll('.switch-image img');

function switchImage(addr) {
	imageAddr = `/images/products/${addr}`;
	mainImage.src = imageAddr;
	images.forEach((image) => {
		image.classList.remove('selected');
		if (image.getAttribute('src') === imageAddr) image.classList.add('selected');
	});
}

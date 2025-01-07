// Switch Image feature
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

// Advice about "Request Quote" feature
const advice = document.querySelector('#advice');
const blurBackground = document.querySelector('#blur-background');

function openAdvice() {
	advice.classList.add('open');
	blurBackground.classList.add('show');
}
function closeAdvice() {
	advice.classList.remove('open');
	blurBackground.classList.remove('show');
}

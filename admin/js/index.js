// Show categories feature

const btnShowCategories = document.querySelector('#btn-show-categories');
const listCategories = document.querySelector('#categories-list');

listCategories.classList.remove('show');
btnShowCategories.value = 'Mostrar categorias';

btnShowCategories.addEventListener('click', () => {
	listCategories.classList.toggle('show');
	if (listCategories.classList.contains('show')) btnShowCategories.value = 'Esconder categorias';
	else btnShowCategories.value = 'Mostrar categorias';
});

// Confirm delete category action

function confirmDeleteCategoryAction() {
	return window.confirm('Tem certeza de que deseja excluir esta categoria?');
}

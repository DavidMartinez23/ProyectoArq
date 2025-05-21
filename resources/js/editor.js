document.addEventListener('DOMContentLoaded', function() {
    const editor = document.querySelector('.editor');
    
    function aplicarFormato(comando, valor = null) {
        document.execCommand(comando, false, valor);
        editor.focus();
    }

    // Configuración de botones
    document.querySelector('.btn-bold').addEventListener('click', () => {
        aplicarFormato('bold');
    });

    document.querySelector('.btn-italic').addEventListener('click', () => {
        aplicarFormato('italic');
    });

    document.querySelector('.btn-h1').addEventListener('click', () => {
        aplicarFormato('formatBlock', '<h1>');
    });

    document.querySelector('.btn-h2').addEventListener('click', () => {
        aplicarFormato('formatBlock', '<h2>');
    });

    document.querySelector('.btn-h3').addEventListener('click', () => {
        aplicarFormato('formatBlock', '<h3>');
    });

    document.querySelector('.btn-ol').addEventListener('click', () => {
        aplicarFormato('insertOrderedList');
    });

    document.querySelector('.btn-ul').addEventListener('click', () => {
        aplicarFormato('insertUnorderedList');
    });

    document.querySelector('.btn-link').addEventListener('click', () => {
        const url = prompt('Ingresa la URL:');
        if (url) {
            aplicarFormato('createLink', url);
        }
    });
});
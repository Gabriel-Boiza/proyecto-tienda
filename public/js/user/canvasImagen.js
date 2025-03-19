document.addEventListener('DOMContentLoaded', function() {
    const image = document.getElementById('product-image');
    const canvas = document.getElementById('productCanvas');
    const ctx = canvas.getContext('2d', { alpha: true });
    
    // Referencias a los controles
    const colorPicker = document.getElementById('colorPicker');
    const lineWidthInput = document.getElementById('lineWidth');
    const lineWidthValue = document.getElementById('lineWidthValue');
    const clearButton = document.getElementById('clearCanvas');
    const pencilTool = document.getElementById('pencilTool');
    const textTool = document.getElementById('textTool');
    const eraserTool = document.getElementById('eraserTool');

    // Variables de estado
    let isDrawing = false;
    let lastX = 0;
    let lastY = 0;
    let currentTool = 'pencil';
    let previousColor = '#FF0000';
    let fontSize = 20; // Tamaño de fuente predeterminado
    let isTyping = false;
    let currentInput = null;

    // Configuración inicial del contexto
    function setupCanvas() {
        ctx.strokeStyle = colorPicker.value;
        ctx.lineWidth = lineWidthInput.value;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';
        ctx.font = `${fontSize}px Arial`;
        ctx.fillStyle = colorPicker.value;
    }

    // Función para crear input de texto
    function createTextInput(x, y) {
        removeTextInput();
    
        const rect = canvas.getBoundingClientRect();
        const pos = getMousePos({ clientX: x, clientY: y });
    
        const input = document.createElement('input');
        input.type = 'text';
        input.style.position = 'absolute';
        input.style.left = `${x - rect.left}px`; // Ajustar posición relativa al canvas
        input.style.top = `${y - rect.top}px`;   // Ajustar posición relativa al canvas
        input.style.background = 'transparent';
        input.style.border = 'none';
        input.style.outline = 'none';
        input.style.color = colorPicker.value;
        input.style.font = `${fontSize}px Arial`;
        input.style.zIndex = '1000';
        input.style.minWidth = '100px';
        input.style.transform = 'translate(-2px, -50%)'; // Centrar verticalmente y ajustar ligeramente
        input.style.pointerEvents = 'auto'; // Asegurar que recibe eventos
    
        // Guardar las coordenadas reales del canvas
        input.dataset.canvasX = pos.x;
        input.dataset.canvasY = pos.y;
    
        // Prevenir que el input mueva la imagen
        input.addEventListener('mousedown', (e) => {
            e.stopPropagation();
        });
    
        canvas.parentElement.appendChild(input);
        input.focus();
    
        currentInput = input;
        isTyping = true;
    
        input.addEventListener('blur', finalizeText);
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                input.blur();
            }
            e.stopPropagation(); // Prevenir que los eventos de teclado afecten al canvas
        });
    }// Eventos de mouse
    canvas.addEventListener('mousedown', (e) => {
        e.preventDefault(); // Prevenir comportamiento por defecto
        e.stopPropagation(); // Prevenir propagación del evento
        
        const pos = getMousePos(e);
    
        if (currentTool === 'text') {
            createTextInput(e.clientX, e.clientY);
        } else {
            isDrawing = true;
            [lastX, lastY] = [pos.x, pos.y];
        }
    });

    // Función para finalizar el texto
    function finalizeText() {
        if (!currentInput) return;

        const text = currentInput.value;
        if (text) {
            // Usar las coordenadas guardadas en el dataset
            const x = parseFloat(currentInput.dataset.canvasX);
            const y = parseFloat(currentInput.dataset.canvasY);

            ctx.font = `${fontSize}px Arial`;
            ctx.fillStyle = colorPicker.value;
            ctx.fillText(text, x, y + fontSize/2); // Ajuste vertical para centrar mejor el texto
        }

        removeTextInput();
    }

    // Función para eliminar el input de texto
    function removeTextInput() {
        if (currentInput && currentInput.parentNode) {
            currentInput.parentNode.removeChild(currentInput);
        }
        currentInput = null;
        isTyping = false;
    }

    // Función para ajustar el tamaño del canvas
    function resizeCanvas() {
        const rect = canvas.getBoundingClientRect();
        const oldCanvas = canvas.toDataURL();
        
        // Establecer las dimensiones del canvas
        canvas.width = rect.width;
        canvas.height = rect.height;
        
        canvas.style.width = `${rect.width}px`;
        canvas.style.height = `${rect.height}px`;

        ctx.clearRect(0, 0, canvas.width, canvas.height);

        const img = new Image();
        img.onload = () => {
            setupCanvas();
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
        };
        img.src = oldCanvas;
    }

    function getMousePos(e) {
        const rect = canvas.getBoundingClientRect();
        const scaleX = canvas.width / rect.width;
        const scaleY = canvas.height / rect.height;
        
        return {
            x: (e.clientX - rect.left) * scaleX,
            y: (e.clientY - rect.top) * scaleY
        };
    }

    function draw(e) {
        if (!isDrawing || currentTool === 'text') return;
        e.preventDefault();
        
        const pos = getMousePos(e);

        ctx.beginPath();
        ctx.moveTo(lastX, lastY);
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();

        [lastX, lastY] = [pos.x, pos.y];
    }

    // Event Listeners para los controles
    colorPicker.addEventListener('change', (e) => {
        const newColor = e.target.value;
        if (currentTool !== 'eraser') {
            ctx.strokeStyle = newColor;
            ctx.fillStyle = newColor;
            previousColor = newColor;
        }
        if (currentInput) {
            currentInput.style.color = newColor;
        }
    });

    lineWidthInput.addEventListener('input', (e) => {
        const width = e.target.value;
        ctx.lineWidth = width;
        lineWidthValue.textContent = width + 'px';
        fontSize = width * 10; // Ajustar tamaño de fuente basado en el ancho de línea
        if (currentInput) {
            currentInput.style.font = `${fontSize}px Arial`;
        }
    });

    clearButton.addEventListener('click', () => {
        if (confirm('¿Estás seguro de que quieres borrar todo el dibujo?')) {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            removeTextInput();
        }
    });

    // Cambio de herramientas
    pencilTool.addEventListener('click', () => {
        currentTool = 'pencil';
        ctx.strokeStyle = previousColor;
        ctx.globalCompositeOperation = 'source-over';
        removeTextInput();
        updateToolButtons(pencilTool);
    });

    textTool.addEventListener('click', () => {
        currentTool = 'text';
        ctx.fillStyle = previousColor;
        ctx.globalCompositeOperation = 'source-over';
        updateToolButtons(textTool);
    });

    eraserTool.addEventListener('click', () => {
        currentTool = 'eraser';
        previousColor = ctx.strokeStyle;
        ctx.globalCompositeOperation = 'destination-out';
        removeTextInput();
        updateToolButtons(eraserTool);
    });

    function updateToolButtons(activeButton) {
        // Resetear todos los botones
        [pencilTool, textTool, eraserTool].forEach(btn => {
            btn.classList.remove('bg-purple-600');
            btn.classList.add('bg-gray-700');
        });
        // Activar el botón seleccionado
        activeButton.classList.remove('bg-gray-700');
        activeButton.classList.add('bg-purple-600');
    }

    

    canvas.addEventListener('mousemove', draw);
    
    canvas.addEventListener('mouseup', (e) => {
        e.preventDefault();
        isDrawing = false;
    });

    canvas.addEventListener('mouseleave', (e) => {
        e.preventDefault();
        isDrawing = false;
    });

    // Eventos táctiles
    canvas.addEventListener('touchstart', (e) => {
        e.preventDefault();
        const touch = e.touches[0];
        const pos = getMousePos(touch);

        if (currentTool === 'text') {
            createTextInput(touch.clientX, touch.clientY);
        } else {
            isDrawing = true;
            [lastX, lastY] = [pos.x, pos.y];
        }
    });

    canvas.addEventListener('touchmove', (e) => {
        e.preventDefault();
        const touch = e.touches[0];
        draw(touch);
    });

    canvas.addEventListener('touchend', (e) => {
        e.preventDefault();
        isDrawing = false;
    });

    // Referencias adicionales
    const imageInput = document.getElementById('imageInput');

    // Variable para la imagen actual
    let currentImage = null;
    let isImageDragging = false;
    let imageStartX = 0;
    let imageStartY = 0;

    // Función para cargar imagen
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const img = new Image();
                img.onload = function() {
                    // Calcular dimensiones para ajustar la imagen al canvas
                    const maxWidth = canvas.width * 0.8;
                    const maxHeight = canvas.height * 0.8;
                    let width = img.width;
                    let height = img.height;

                    if (width > maxWidth) {
                        const ratio = maxWidth / width;
                        width = maxWidth;
                        height = height * ratio;
                    }
                    if (height > maxHeight) {
                        const ratio = maxHeight / height;
                        height = maxHeight;
                        width = width * ratio;
                    }

                    // Posicionar la imagen en el centro del canvas
                    const x = (canvas.width - width) / 2;
                    const y = (canvas.height - height) / 2;

                    currentImage = {
                        element: img,
                        x: x,
                        y: y,
                        width: width,
                        height: height
                    };

                    // Dibujar la imagen
                    drawCanvas();
                };
                img.src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Función para dibujar el canvas con la imagen
    function drawCanvas() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        if (currentImage) {
            ctx.drawImage(
                currentImage.element,
                currentImage.x,
                currentImage.y,
                currentImage.width,
                currentImage.height
            );
        }
    }

    // Eventos para mover la imagen
    canvas.addEventListener('mousedown', function(e) {
        if (currentImage) {
            const pos = getMousePos(e);
            
            // Comprobar si el clic está dentro de la imagen
            if (pos.x >= currentImage.x && 
                pos.x <= currentImage.x + currentImage.width &&
                pos.y >= currentImage.y && 
                pos.y <= currentImage.y + currentImage.height) {
                
                isImageDragging = true;
                imageStartX = pos.x - currentImage.x;
                imageStartY = pos.y - currentImage.y;
                e.preventDefault();
            }
        }
    });

    canvas.addEventListener('mousemove', function(e) {
        if (isImageDragging && currentImage) {
            const pos = getMousePos(e);
            
            currentImage.x = pos.x - imageStartX;
            currentImage.y = pos.y - imageStartY;
            
            drawCanvas();
            e.preventDefault();
        }
    });

    canvas.addEventListener('mouseup', function() {
        isImageDragging = false;
    });

    canvas.addEventListener('mouseleave', function() {
        isImageDragging = false;
    });

    // Modificar la función clearCanvas para resetear también la imagen
    function clearCanvas() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        currentImage = null;
    }

    // Inicialización
    resizeCanvas();
    setupCanvas();

    // Ajustar el canvas cuando la ventana cambie de tamaño
    window.addEventListener('resize', resizeCanvas);
});
 
function saveCanvasAsProduct() {
    console.log('Iniciando guardado...');
    
    const loadingIndicator = showLoadingIndicator();
    const canvas = document.getElementById('productCanvas');
    const canvasImage = canvas.toDataURL('image/png');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    fetch('/products/store', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            image: canvasImage
        })
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => {
                console.error('Error response:', text);
                throw new Error('Error en la respuesta del servidor');
            });
        }
        return response.json();
    })
    .then(data => {
        console.log('Respuesta exitosa:', data);
        hideLoadingIndicator(loadingIndicator);
        if (data.success) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Producto añadido al carrito',
                    icon: 'success',
                    confirmButtonColor: '#6366f1'
                }).then(() => {
                    window.location.href = data.redirect;
                });
            } else {
                alert('¡Producto añadido al carrito!');
                window.location.href = data.redirect;
            }
        } else {
            throw new Error(data.message || 'Error al guardar el diseño');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        hideLoadingIndicator(loadingIndicator);
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Error',
                text: error.message,
                icon: 'error',
                confirmButtonColor: '#6366f1'
            });
        } else {
            alert('Error: ' + error.message);
        }
    });
}

// Funciones auxiliares para UI
function showLoadingIndicator() {
    const loader = document.createElement('div');
    loader.className = 'fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-50 z-50';
    loader.innerHTML = `
        <div class="bg-white p-5 rounded-lg flex flex-col items-center">
            <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-purple-600"></div>
            <p class="mt-2 text-gray-700">Guardando diseño...</p>
        </div>
    `;
    document.body.appendChild(loader);
    return loader;
}

function hideLoadingIndicator(loader) {
    if (loader && loader.parentNode) {
        loader.parentNode.removeChild(loader);
    }
}

// Agregar el evento click al botón de guardar
document.addEventListener('DOMContentLoaded', function() {
    const saveButton = document.getElementById('saveButton');
    if (saveButton) {
        saveButton.addEventListener('click', saveCanvasAsProduct);
    }
});
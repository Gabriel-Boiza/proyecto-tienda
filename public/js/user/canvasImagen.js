document.addEventListener('DOMContentLoaded', function() {
    const image = document.getElementById('product-image');
    const canvas = document.getElementById('productCanvas');
    
    // Verificar que los elementos existen
    if (!canvas) {
        console.error('Canvas no encontrado');
        return;
    }
    
    const ctx = canvas.getContext('2d', { alpha: true });
    
    // Referencias a los controles
    const colorPicker = document.getElementById('colorPicker');
    const lineWidthInput = document.getElementById('lineWidth');
    const lineWidthValue = document.getElementById('lineWidthValue');
    const clearButton = document.getElementById('clearCanvas');
    const pencilTool = document.getElementById('pencilTool');
    const textTool = document.getElementById('textTool');
    const eraserTool = document.getElementById('eraserTool');
    const imageInput = document.getElementById('imageInput');

    // Referencias para el toggle
    const toggleToolsBtn = document.getElementById('toggleTools');
    const toolsPanel = document.getElementById('toolsPanel');
    const canvasContainer = document.getElementById('canvasContainer');

    // Variables de estado
    let isDrawing = false;
    let lastX = 0;
    let lastY = 0;
    let currentTool = 'pencil';
    let previousColor = '#FF0000';
    let fontSize = 20;
    let isTyping = false;
    let currentInput = null;
    let isCanvasInitialized = false;
    
    // Variables para manejo de imágenes
    let currentImage = null;
    let isResizingImage = false;
    let resizeHandle = null;
    let imageStartX = 0;
    let imageStartY = 0;
    let imageStartWidth = 0;
    let imageStartHeight = 0;
    let dragStartX = 0;
    let dragStartY = 0;
    let isDraggingImage = false;
    // Variables para el manejo de capas
    let drawingLayer = null; // Canvas para dibujos
    let drawingCtx = null;   // Contexto del canvas de dibujos

    // Función para inicializar las capas
    function initializeLayers() {
        // Crear capa de dibujo si no existe
        if (!drawingLayer) {
            drawingLayer = document.createElement('canvas');
            drawingLayer.width = canvas.width;
            drawingLayer.height = canvas.height;
            drawingCtx = drawingLayer.getContext('2d');
        } else {
            // Asegurarse de que tenga el tamaño correcto
            drawingLayer.width = canvas.width;
            drawingLayer.height = canvas.height;
        }
    }
    // Configuración inicial del contexto
    function setupCanvas() {
        if (!ctx) return;
        
        // Configurar el contexto principal
        ctx.strokeStyle = colorPicker ? colorPicker.value : '#FF0000';
        ctx.lineWidth = lineWidthInput ? lineWidthInput.value : 2;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';
        ctx.font = `${fontSize}px Arial`;
        ctx.fillStyle = colorPicker ? colorPicker.value : '#FF0000';
        
        // Configurar también la capa de dibujo
        if (drawingCtx) {
            drawingCtx.strokeStyle = ctx.strokeStyle;
            drawingCtx.lineWidth = ctx.lineWidth;
            drawingCtx.lineCap = ctx.lineCap;
            drawingCtx.lineJoin = ctx.lineJoin;
            drawingCtx.font = ctx.font;
            drawingCtx.fillStyle = ctx.fillStyle;
        }
        
        console.log('Canvas configurado correctamente');
    }

    // Función para inicializar completamente el canvas
    function initializeCanvas() {
        if (isCanvasInitialized) return;
        
        // Establecer dimensiones iniciales
        const rect = canvasContainer.getBoundingClientRect();
        canvas.width = rect.width;
        canvas.height = rect.height;
        
        // Inicializar capas
        initializeLayers();
        
        // Configurar el contexto
        setupCanvas();
        
        // Marcar como inicializado
        isCanvasInitialized = true;
        console.log('Canvas inicializado completamente');
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
    }

    function setupMouseEvents() {
        canvas.addEventListener('mousedown', handleMouseDown);
        canvas.addEventListener('mousemove', handleMouseMove);
        canvas.addEventListener('mouseup', handleMouseUp);
        canvas.addEventListener('mouseleave', () => {
            isDrawing = false;
            isDraggingImage = false;
            isResizingImage = false;
        });
        
        // Eventos táctiles
        canvas.addEventListener('touchstart', handleTouchStart);
        canvas.addEventListener('touchmove', handleTouchMove);
        canvas.addEventListener('touchend', handleTouchEnd);
    }
    
    function handleMouseDown(e) {
        e.preventDefault();
        const pos = getMousePos(e);
        
        // Si hay una imagen seleccionada, verificar si estamos en un control de redimensionamiento
        if (currentImage) {
            const imageRight = currentImage.x + currentImage.width;
            const imageBottom = currentImage.y + currentImage.height;
            
            // Verificar si el clic está en el control de redimensionamiento (esquina inferior derecha)
            if (Math.abs(pos.x - imageRight) < 10 && Math.abs(pos.y - imageBottom) < 10) {
                isResizingImage = true;
                resizeHandle = 'bottomRight';
                imageStartWidth = currentImage.width;
                imageStartHeight = currentImage.height;
                dragStartX = pos.x;
                dragStartY = pos.y;
                return;
            }
            
            // Verificar si el clic está dentro de la imagen para arrastrarla
            if (pos.x >= currentImage.x && pos.x <= imageRight && 
                pos.y >= currentImage.y && pos.y <= imageBottom) {
                isDraggingImage = true;
                imageStartX = currentImage.x;
                imageStartY = currentImage.y;
                dragStartX = pos.x;
                dragStartY = pos.y;
                return;
            }
            
            // Si el clic no está en la imagen ni en el control, aplanar la imagen en la capa de dibujo
            flattenImageToDrawingLayer();
        }
    
        if (currentTool === 'text') {
            createTextInput(e.clientX, e.clientY);
        } else {
            isDrawing = true;
            [lastX, lastY] = [pos.x, pos.y];
            
            // Si estamos usando el borrador, asegurarse de que esté configurado correctamente
            if (currentTool === 'eraser') {
                drawingCtx.globalCompositeOperation = 'destination-out';
                drawingCtx.strokeStyle = 'rgba(0,0,0,1)'; // Color no importa para borrar
            }
        }
    }
    
    // Nueva función para aplanar la imagen en la capa de dibujo
    function flattenImageToDrawingLayer() {
        if (!currentImage || !currentImage.img) return;
        
        // Guardar el modo de composición actual
        const currentCompositeOperation = drawingCtx.globalCompositeOperation;
        
        // Establecer el modo de composición normal
        drawingCtx.globalCompositeOperation = 'source-over';
        
        // Dibujar la imagen en la capa de dibujo
        drawingCtx.drawImage(
            currentImage.img, 
            currentImage.x, 
            currentImage.y, 
            currentImage.width, 
            currentImage.height
        );
        
        // Restaurar el modo de composición
        drawingCtx.globalCompositeOperation = currentCompositeOperation;
        
        // Eliminar la referencia a la imagen actual
        currentImage = null;
        
        // Redibujar el canvas
        redrawCanvas();
        
        console.log('Imagen aplanada en la capa de dibujo');
    }
    
    function handleMouseMove(e) {
        e.preventDefault();
        const pos = getMousePos(e);
        
        // Cambiar el cursor según la posición
        if (currentImage) {
            const imageRight = currentImage.x + currentImage.width;
            const imageBottom = currentImage.y + currentImage.height;
            
            if (Math.abs(pos.x - imageRight) < 10 && Math.abs(pos.y - imageBottom) < 10) {
                canvas.style.cursor = 'nwse-resize';
            } else if (pos.x >= currentImage.x && pos.x <= imageRight && 
                       pos.y >= currentImage.y && pos.y <= imageBottom) {
                canvas.style.cursor = 'move';
            } else {
                canvas.style.cursor = 'default';
            }
        } else {
            canvas.style.cursor = 'default';
        }
        
        // Manejar redimensionamiento de imagen
        if (isResizingImage && currentImage) {
            const deltaX = pos.x - dragStartX;
            const deltaY = pos.y - dragStartY;
            
            if (resizeHandle === 'bottomRight') {
                currentImage.width = Math.max(20, imageStartWidth + deltaX);
                currentImage.height = Math.max(20, imageStartHeight + deltaY);
            }
            
            redrawCanvas();
            return;
        }
        
        // Manejar arrastre de imagen
        if (isDraggingImage && currentImage) {
            const deltaX = pos.x - dragStartX;
            const deltaY = pos.y - dragStartY;
            
            currentImage.x = imageStartX + deltaX;
            currentImage.y = imageStartY + deltaY;
            
            redrawCanvas();
            return;
        }
        
        // Dibujo normal
        if (isDrawing && currentTool !== 'text') {
            draw(e);
        }
    }
    
    function handleMouseUp(e) {
        isDrawing = false;
        isDraggingImage = false;
        isResizingImage = false;
        
        // Si estábamos usando el borrador, restaurar la configuración original
        if (currentTool === 'eraser') {
            // Mantener el modo de composición para borrar
            drawingCtx.globalCompositeOperation = 'destination-out';
        }
    }
    
    function handleTouchStart(e) {
        e.preventDefault();
        const touch = e.touches[0];
        const pos = getMousePos(touch);
        
        // Lógica similar a mouseDown para imágenes
        if (currentImage) {
            const imageRight = currentImage.x + currentImage.width;
            const imageBottom = currentImage.y + currentImage.height;
            
            if (Math.abs(pos.x - imageRight) < 20 && Math.abs(pos.y - imageBottom) < 20) {
                isResizingImage = true;
                resizeHandle = 'bottomRight';
                imageStartWidth = currentImage.width;
                imageStartHeight = currentImage.height;
                dragStartX = pos.x;
                dragStartY = pos.y;
                return;
            }
            
            if (pos.x >= currentImage.x && pos.x <= imageRight && 
                pos.y >= currentImage.y && pos.y <= imageBottom) {
                isDraggingImage = true;
                imageStartX = currentImage.x;
                imageStartY = currentImage.y;
                dragStartX = pos.x;
                dragStartY = pos.y;
                return;
            }
            
            // Si el toque no está en la imagen ni en el control, aplanar la imagen
            flattenImageToDrawingLayer();
        }
    
        if (currentTool === 'text') {
            createTextInput(touch.clientX, touch.clientY);
        } else {
            isDrawing = true;
            [lastX, lastY] = [pos.x, pos.y];
        }
    }
    
    function handleTouchMove(e) {
        e.preventDefault();
        const touch = e.touches[0];
        const pos = getMousePos(touch);
        
        // Manejar redimensionamiento de imagen
        if (isResizingImage && currentImage) {
            const deltaX = pos.x - dragStartX;
            const deltaY = pos.y - dragStartY;
            
            if (resizeHandle === 'bottomRight') {
                currentImage.width = Math.max(20, imageStartWidth + deltaX);
                currentImage.height = Math.max(20, imageStartHeight + deltaY);
            }
            
            redrawCanvas();
            return;
        }
        
        // Manejar arrastre de imagen
        if (isDraggingImage && currentImage) {
            const deltaX = pos.x - dragStartX;
            const deltaY = pos.y - dragStartY;
            
            currentImage.x = imageStartX + deltaX;
            currentImage.y = imageStartY + deltaY;
            
            redrawCanvas();
            return;
        }
        
        // Dibujo normal
        if (isDrawing && currentTool !== 'text') {
            draw(touch);
        }
    }
    
    function handleTouchEnd(e) {
        isDrawing = false;
        isDraggingImage = false;
        isResizingImage = false;
    }

    // Función para finalizar el texto
    function finalizeText() {
        if (!currentInput) return;
    
        const text = currentInput.value;
        if (text) {
            // Usar las coordenadas guardadas en el dataset
            const x = parseFloat(currentInput.dataset.canvasX);
            const y = parseFloat(currentInput.dataset.canvasY);
    
            drawingCtx.font = `${fontSize}px Arial`;
            drawingCtx.fillStyle = colorPicker.value;
            drawingCtx.fillText(text, x, y + fontSize/2); // Ajuste vertical para centrar mejor el texto
            
            // Redibujar todo
            redrawCanvas();
        }
    
        removeTextInput();
    }
    if (clearButton) {
        clearButton.addEventListener('click', () => {
            // Limpiar la capa de dibujo
            drawingCtx.clearRect(0, 0, drawingLayer.width, drawingLayer.height);
            // Limpiar la imagen
            currentImage = null;
            // Redibujar
            redrawCanvas();
            removeTextInput();
        });
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
        if (!canvas || !canvasContainer) return;
        
        // Guardar el contenido actual
        const oldCanvas = canvas.toDataURL();
        
        // Obtener las dimensiones del contenedor
        const rect = canvasContainer.getBoundingClientRect();
        
        // Establecer las dimensiones del canvas
        canvas.width = rect.width;
        canvas.height = rect.height;
        
        canvas.style.width = `${rect.width}px`;
        canvas.style.height = `${rect.height}px`;

        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Restaurar el contenido
        const img = new Image();
        img.onload = () => {
            setupCanvas();
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
        };
        img.src = oldCanvas;
        
        console.log(`Canvas redimensionado a ${rect.width}x${rect.height}`);
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
    
        // Dibujar en la capa de dibujo
        drawingCtx.beginPath();
        drawingCtx.moveTo(lastX, lastY);
        drawingCtx.lineTo(pos.x, pos.y);
        drawingCtx.stroke();
    
        [lastX, lastY] = [pos.x, pos.y];
        
        // Redibujar todo
        redrawCanvas();
    }

    // Función para redibujar el canvas con todas las capas
    function redrawCanvas() {
        // Limpiar el canvas principal
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        // Dibujar la capa de dibujo
        ctx.drawImage(drawingLayer, 0, 0);
        
        // Si hay una imagen, dibujarla encima
        if (currentImage && currentImage.img) {
            // Dibujar la imagen
            ctx.drawImage(
                currentImage.img, 
                currentImage.x, 
                currentImage.y, 
                currentImage.width, 
                currentImage.height
            );
            
            // Dibujar los controles de redimensionamiento
            ctx.strokeStyle = '#00AAFF';
            ctx.lineWidth = 2;
            ctx.strokeRect(
                currentImage.x, 
                currentImage.y, 
                currentImage.width, 
                currentImage.height
            );
            
            // Dibujar el control de redimensionamiento en la esquina inferior derecha
            const handleSize = 10;
            ctx.fillStyle = '#00AAFF';
            ctx.fillRect(
                currentImage.x + currentImage.width - handleSize/2, 
                currentImage.y + currentImage.height - handleSize/2, 
                handleSize, 
                handleSize
            );
            
            // Restaurar estilos
            ctx.strokeStyle = colorPicker ? colorPicker.value : '#FF0000';
            ctx.lineWidth = lineWidthInput ? lineWidthInput.value : 2;
        }
    }

    // Función para manejar la carga de imágenes
    function handleImageUpload(e) {
        const file = e.target.files[0];
        if (!file) return;
        
        const reader = new FileReader();
        reader.onload = function(event) {
            const img = new Image();
            img.onload = function() {
                // Calcular dimensiones proporcionales
                let width = img.width;
                let height = img.height;
                const maxSize = Math.min(canvas.width, canvas.height) * 0.8;
                
                if (width > height) {
                    if (width > maxSize) {
                        height = height * (maxSize / width);
                        width = maxSize;
                    }
                } else {
                    if (height > maxSize) {
                        width = width * (maxSize / height);
                        height = maxSize;
                    }
                }
                
                // Crear objeto de imagen
                currentImage = {
                    img: img,
                    x: (canvas.width - width) / 2,
                    y: (canvas.height - height) / 2,
                    width: width,
                    height: height
                };
                
                // Redibujar el canvas sin borrar el contenido existente
                redrawCanvas();
            };
            img.src = event.target.result;
        };
        reader.readAsDataURL(file);
    }

    // Configurar eventos de herramientas
    function setupToolEvents() {
        // Event Listeners para los controles
        if (colorPicker) {
            colorPicker.addEventListener('change', (e) => {
                const newColor = e.target.value;
                if (currentTool !== 'eraser') {
                    ctx.strokeStyle = newColor;
                    ctx.fillStyle = newColor;
                    drawingCtx.strokeStyle = newColor;
                    drawingCtx.fillStyle = newColor;
                    previousColor = newColor;
                }
                if (currentInput) {
                    currentInput.style.color = newColor;
                }
            });
        }
    
        if (lineWidthInput && lineWidthValue) {
            lineWidthInput.addEventListener('input', (e) => {
                const width = e.target.value;
                ctx.lineWidth = width;
                drawingCtx.lineWidth = width;
                lineWidthValue.textContent = width + 'px';
                fontSize = width * 10; // Ajustar tamaño de fuente basado en el ancho de línea
                if (currentInput) {
                    currentInput.style.font = `${fontSize}px Arial`;
                }
            });
        }
    
        if (clearButton) {
            clearButton.addEventListener('click', () => {
                // Limpiar la capa de dibujo
                drawingCtx.clearRect(0, 0, drawingLayer.width, drawingLayer.height);
                // Limpiar la imagen
                currentImage = null;
                // Redibujar
                redrawCanvas();
                removeTextInput();
            });
        }
    
        // Cambio de herramientas
        if (pencilTool) {
            pencilTool.addEventListener('click', () => {
                currentTool = 'pencil';
                drawingCtx.strokeStyle = previousColor;
                drawingCtx.globalCompositeOperation = 'source-over';
                removeTextInput();
                updateToolButtons(pencilTool);
            });
        }
    
        if (textTool) {
            textTool.addEventListener('click', () => {
                currentTool = 'text';
                drawingCtx.fillStyle = previousColor;
                drawingCtx.globalCompositeOperation = 'source-over';
                updateToolButtons(textTool);
            });
        }
    
        if (eraserTool) {
            eraserTool.addEventListener('click', () => {
                currentTool = 'eraser';
                previousColor = drawingCtx.strokeStyle;
                // Cambiar el modo de composición para borrar
                drawingCtx.globalCompositeOperation = 'destination-out';
                // Aumentar el tamaño del borrador para facilitar el borrado
                drawingCtx.lineWidth = lineWidthInput ? parseInt(lineWidthInput.value) * 2 : 10;
                removeTextInput();
                updateToolButtons(eraserTool);
            });
        }
        
        // Manejo de carga de imágenes
        if (imageInput) {
            imageInput.addEventListener('change', handleImageUpload);
        }
    }

    function updateToolButtons(activeButton) {
        // Resetear todos los botones
        [pencilTool, textTool, eraserTool].forEach(btn => {
            if (btn) {
                btn.classList.remove('bg-purple-600');
                btn.classList.add('bg-gray-700');
            }
        });
        // Activar el botón seleccionado
        if (activeButton) {
            activeButton.classList.remove('bg-gray-700');
            activeButton.classList.add('bg-purple-600');
        }
    }

    // Toggle para mostrar/ocultar herramientas y canvas
    if (toggleToolsBtn && toolsPanel && canvasContainer) {
        console.log('Configurando evento de toggle');
        
        toggleToolsBtn.addEventListener('click', function() {
            console.log('Botón de toggle pulsado');
            
            // Toggle del panel de herramientas
            if (toolsPanel.classList.contains('hidden')) {
                toolsPanel.classList.remove('hidden');
                console.log('Panel de herramientas mostrado');
            } else {
                toolsPanel.classList.add('hidden');
                console.log('Panel de herramientas ocultado');
            }
            
            // Toggle del contenedor del canvas
            if (canvasContainer.style.display === 'none' || canvasContainer.style.display === '') {
                canvasContainer.style.display = 'block';
                console.log('Canvas mostrado');
                
                // Inicializar el canvas si es necesario
                if (!isCanvasInitialized) {
                    initializeCanvas();
                    setupMouseEvents();
                    setupToolEvents();
                }
                
                // Pequeño retraso para asegurar que el DOM se ha actualizado
                setTimeout(() => {
                    resizeCanvas();
                    setupCanvas();
                }, 50);
            } else {
                canvasContainer.style.display = 'none';
                console.log('Canvas ocultado');
            }
        });
    } else {
        console.error('No se pudieron configurar los eventos de toggle');
    }

    // Configurar eventos iniciales
    setupToolEvents();
    
    // Ajustar el canvas cuando la ventana cambie de tamaño
    window.addEventListener('resize', resizeCanvas);
});

// Función para guardar el canvas como producto
function saveCanvasAsProduct() {
    // Mostrar indicador de carga
    const loadingIndicator = showLoadingIndicator();
    
    try {
        // Obtener la imagen del producto
        const productImage = document.getElementById('product-image');
        if (!productImage) {
            throw new Error('No se encontró la imagen del producto');
        }
        
        // Crear un canvas temporal
        const tempCanvas = document.createElement('canvas');
        tempCanvas.width = productImage.width;
        tempCanvas.height = productImage.height;
        
        const tempCtx = tempCanvas.getContext('2d');
        
        // Dibujar la imagen del producto
        tempCtx.drawImage(productImage, 0, 0, tempCanvas.width, tempCanvas.height);
        
        // Obtener el canvas de personalización
        const productCanvas = document.getElementById('productCanvas');
        if (!productCanvas) {
            throw new Error('No se encontró el canvas de personalización');
        }
        
        const canvasRect = productCanvas.getBoundingClientRect();
        const imageRect = productImage.getBoundingClientRect();
        
        // Calcular posiciones
        const x = (canvasRect.left - imageRect.left) * (tempCanvas.width / imageRect.width);
        const y = (canvasRect.top - imageRect.top) * (tempCanvas.height / imageRect.height);
        const width = canvasRect.width * (tempCanvas.width / imageRect.width);
        const height = canvasRect.height * (tempCanvas.height / imageRect.height);
        
        // Dibujar la personalización
        tempCtx.drawImage(productCanvas, x, y, width, height);
        
        // Convertir a base64
        const finalImage = tempCanvas.toDataURL('image/png');
        
        // Obtener el token CSRF
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!csrfToken) {
            throw new Error('Token CSRF no encontrado');
        }
        
        // Preparar datos
        const formData = new FormData();
        formData.append('image', finalImage);
        formData.append('producto_id', document.getElementById('agregar').value);
        
        // Enviar al servidor
        fetch('/save-personalized', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.message || 'Error en el servidor');
                });
            }
            return response.json();
        })
        .then(data => {
            hideLoadingIndicator(loadingIndicator);
            if (data.success) {
                alert('Diseño guardado correctamente');
            } else {
                throw new Error(data.message || 'Error al guardar el diseño');
            }
        })
        .catch(error => {
            hideLoadingIndicator(loadingIndicator);
            alert(error.message || 'Error al procesar la solicitud');
        });
        
    } catch (error) {
        hideLoadingIndicator(loadingIndicator);
        alert(error.message || 'Error al procesar la imagen');
    }
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
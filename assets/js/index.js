let selectedFile;
document.addEventListener('DOMContentLoaded', function () {
    const extBlacklist = [ // Extensiones no permitidas
        ".js", ".jar", ".scr", ".cpl", ".jsp", ".doc", ".docx",
    ];

    const fileTypes = [ // Asociaciones de extensiones
        { icon: 'image', name: 'Imagen', extensions: ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'ico'] },
        { icon: 'music', name: 'Audio', extensions: ['mp3', 'wav', 'm4a', 'flac', 'aac', 'ogg'] },
        { icon: 'video', name: 'Video', extensions: ['mp4', 'mov', 'avi', 'mkv', 'wmv', 'flv'] },
        { icon: 'archive', name: 'Archivo Comprimido', extensions: ['zip', 'rar', 'tar', '7z', 'gz', 'iso', 'torrent'] },
        { icon: 'code', name: 'Codigo Fuente', extensions: ['html', 'htm', 'css', 'js', 'py', 'cpp', 'php'] },
        { icon: 'file-text', name: 'Texto', extensions: ['txt', 'md', 'json'] },
        { icon: 'package', name: 'Ejecutable', extensions: ['exe', 'apk', 'dmg', 'app', 'deb'] },
        { icon: 'type', name: 'Fuente', extensions: ['ttf', 'otf', 'woff', 'woff2'] },
    ];

    // Obtener elementos del documento
    const dropArea = document.getElementById('dropArea');
    const fileInput = document.getElementById('fileInput');

    feather.replace(); // Cargar Iconos

    // Inicializar micromodal
    MicroModal.init({
        disableFocus: true,
    });

    /* ------------------------------- Background ------------------------------- */
    const rand = (min, max) => Math.floor(Math.random() * (max - min + 1) + min);
    const colors = ["#001f3f", "#0074D9"];

    const randBorderRadius = () =>
        [...Array(4).keys()].map((x) => rand(30, 85) + "%").join(" ") +
        " / " +
        [...Array(4).keys()].map((x) => rand(30, 85) + "%").join(" ");

    const genBlobs = () => {
        [...Array(5).keys()].map((id) => {
            const x = rand(25, 75);
            const y = rand(25, 75);
            const color = colors[rand(0, colors.length)];
            createBlob({ x, y, color, id });
        });
    };

    const createBlob = ({ id, x, y, color }) => {
        const background = document.querySelector(".background");
        const blob = document.createElement("div");

        blob.id = `blob-${id}`;
        blob.classList.add("blob");
        blob.style.top = `${y}%`;
        blob.style.left = `${x}%`;
        blob.style.backgroundColor = color;
        blob.style.scale = rand(1.25, 2);
        blob.style.borderRadius = randBorderRadius();

        background.appendChild(blob);
        animateBlob(id);
    };

    const animateBlob = (id) => {
        anime({
            targets: `#blob-${id}`,
            translateX: () => `+=${rand(-25, 25)}`,
            translateY: () => `+=${rand(-25, 25)}`,
            borderRadius: () => randBorderRadius(),
            rotate: () => rand(-25, 25),
            opacity: () => rand(0.4, 0.8),
            scale: () => rand(1.25, 2),
            duration: 5000,
            easing: "easeInOutQuad",
            complete: (anim) => animateBlob(id)
        }).play();
    };

    genBlobs();

    /* -------------------------------- Efecto 3D ------------------------------- */

    let mouseX = 0;
    let mouseY = 0;

    function updateTilt() {
        const rect = dropArea.getBoundingClientRect();
        const centerX = rect.left + rect.width / 2;
        const centerY = rect.top + rect.height / 2;
        const dx = mouseX - centerX;
        const dy = mouseY - centerY;
        const tiltX = dy * 0.05; // Sensibilidad en el eje Y
        const tiltY = -dx * 0.01; // Sensibilidad en el eje X

        dropArea.style.transform = `perspective(1000px) rotateX(${tiltX}deg) rotateY(${tiltY}deg)`;
        requestAnimationFrame(updateTilt);
    }

    function handleMouseMove(e) {
        mouseX = e.clientX;
        mouseY = e.clientY;
    }

    window.addEventListener('mousemove', handleMouseMove);
    window.addEventListener('dragover', handleMouseMove);
    updateTilt();

    /* ------------------------- Funcionalidad Principal ------------------------ */

    // Prevenir el comportamiento por defecto
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, function (e) {
            e.preventDefault();
            e.stopPropagation();
        });
    });

    // Asigna las clases correspondientes al arrastrar
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, function () {
            dropArea.classList.add('dragover');
        });
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, function () {
            dropArea.classList.remove('dragover');
        });
    });

    dropArea.addEventListener('click', function (e) {
        fileInput.click();
    });


    // Maneja los archivos seleccionados de forma correspondiente
    function handleInput(files) {
        document.querySelectorAll('.divider, .sub')
            .forEach(elem => elem.classList.add('active'));
        handleFile(files[0]);
    }

    fileInput.addEventListener('change', function (e) {
        if (e.target.files.length > 0 && e.target.files[0].name !== '') {
            handleInput(e.target.files);
        } else {
            document.querySelectorAll('.divider, .sub')
                .forEach(elem => elem.classList.remove('active'));
            document.querySelector("#dropArea svg").setAttribute("data-feather", 'upload-cloud');
            document.querySelector('.title.large').textContent = 'ARRASTRA Y SUELTA UN ARCHIVO AQUI';
            document.querySelector('.title.small').textContent = 'SELECCIONA UN ARCHIVO';
            document.querySelector('.sub').textContent = 'haz click para seleccionar';
        }
    });

    dropArea.addEventListener('drop', function (e) {
        e.preventDefault();
        if (e.dataTransfer.items) {
            // Verifica que es un archivo antes de manejarlo
            for (var i = 0; i < e.dataTransfer.items.length; i++) {
                if (e.dataTransfer.items[i].kind === 'file') {
                    handleInput(e.dataTransfer.files);
                    break;
                }
            }
        }
    });


    function handleFile(file) {
        selectedFile = file;
        document.getElementById('uploadBtn').disabled = false;
        function typeInfo(ext) {
            // Obtiene el nombre del tipo de archivo y su icono correspondiente
            for (const fileType of fileTypes) {
                if (fileType.extensions.includes(ext)) {
                    return { fileType: fileType, icon: fileType.icon };
                }
            }
            return { fileType: null, icon: 'file' };
        }

        // Regresa el tamaño del archivo en un formato legible
        function fileSize(size) {
            if (size < 1024) {
                return size + ' B';
            } else if (size < 1048576) {
                return (size / 1024).toFixed(2) + ' KB';
            } else if (size < 1073741824) {
                return (size / 1048576).toFixed(2) + ' MB';
            } else {
                return (size / 1073741824).toFixed(2) + ' GB';
            }
        }

        const name = file.name;
        const size = file.size;
        const ext = name.slice(name.lastIndexOf(".") + 1);

        // Verifica si la extension esta en la lista negra
        if (extBlacklist.includes(`.${ext}`)) {
            console.log('File extension is blacklisted.');
        } else {
            // Actualiza los detalles del archivo
            const { fileType, icon } = typeInfo(ext);
            document.querySelector("#dropArea svg").setAttribute("data-feather", icon);
            document.querySelector('.title.large').textContent = name;
            document.querySelector('.title.small').textContent = name;
            document.querySelector('.sub').textContent = `${fileType ? fileType.name : 'Archivo'}, ${fileSize(size)}`;
            feather.replace();
        }
    }

    /* ---------------------------- Subida de Archivo --------------------------- */

    // Fecha de expiracion
    var expireDropdown = document.getElementById('expireDropdown');
    expireDropdown.onchange = (event) => {
        if (event.target.value === 'expire-0') {
            document.getElementById('maxSize').textContent = 'Tamaño Maximo: 100MB';
        } else {
            document.getElementById('maxSize').textContent = 'Tamaño Maximo: 1GB';
        }
    };

    customSelect('select'); // Remplaza los menus de seleccion
});

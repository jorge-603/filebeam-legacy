document.addEventListener('DOMContentLoaded', function () {
    setInterval(() => {
        if (window.matchMedia("(max-width: 580px)").matches) {
            document.querySelector('#dropArea .title').textContent = "SELECCIONA UN ARCHIVO";
        } else {
            document.querySelector('#dropArea .title').textContent = "ARRASTRA Y SUELTA UN ARCHIVO AQUI";
        }
    }, 1000);

    feather.replace(); // Cargar Iconos

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

    /* ----------------------------- Perspectiva 3D ----------------------------- */

    let mouseX = 0;
    let mouseY = 0;
    const dropArea = document.getElementById('dropArea');

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
    updateTilt();

    /* ---------------------------- Menu de seleccion --------------------------- */

    customSelect('select');
});

document.addEventListener("DOMContentLoaded", function () {
    const sections = document.querySelectorAll(".fade-in-section");

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("visible");
                observer.unobserve(entry.target); // Deja de observar una vez que aparece
            }
        });
    }, { threshold: 0.4 }); // Se activa cuando el 30% del elemento es visible

    sections.forEach(section => observer.observe(section));
});

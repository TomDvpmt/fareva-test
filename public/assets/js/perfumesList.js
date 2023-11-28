const anchorEl = document.getElementById("header");
const perfumes = document.getElementsByClassName("perfume-row");

Array.from(perfumes).forEach((element) => {
    const perfumeCard = document.createElement("div");
    perfumeCard.classList.add("perfume-card");
    const name = element.querySelector("#name").innerText;
    const description = element.querySelector("#description").innerText;
    const components = element.querySelector("#components").innerText;
    perfumeCard.innerHTML = `
        <h3>${name}</h3>
        <p><span><strong>Description:</strong></span> <span>${description}</span></p>
        <p><span><strong>Components:</strong></span> <span>${components}</span></p>
    `;

    element.addEventListener("mouseenter", (e) => {
        anchorEl.appendChild(perfumeCard);
    });

    element.addEventListener("mouseleave", (e) => {
        perfumeCard.remove();
    });
});

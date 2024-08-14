import 'bootstrap/dist/css/bootstrap.min.css';
import './bootstrap';
import '../css/app.css';

document.querySelectorAll('.btn-edit').forEach(button => {
    button.addEventListener("click", function () {
        const row = this.closest("tr");
        row.querySelectorAll("input").forEach((input) =>
            input.removeAttribute("readonly")
        );
        row.querySelector(".btn-update").style.display = "inline-block";
        this.style.display = "none";
    });
});
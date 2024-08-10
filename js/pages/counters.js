const btnPlus = document.getElementById('btn-plus');
const btnMinus = document.getElementById('btn-minus');
const numberBlock = document.getElementById('number');
let number = numberBlock.innerText;

btnPlus.onclick = function () {
    number = +number + 1;
    save(number);
}

btnMinus.onclick = function () {
    number = +number - 1;
    save(number);
}

async function save(number) {
    const url = '/app/ajax/saveNumber.php?number=' + number;
    const response = await fetch(url);
    const result = await response.json();

    if (result.success) {
        numberBlock.innerText = "" + number;
    } else {
        console.log(result.error);
    }
}


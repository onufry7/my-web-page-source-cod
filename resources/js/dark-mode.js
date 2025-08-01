const darkMode = document.getElementById('darkMode')
const lightMode = document.getElementById('lightMode')
const systemMode = document.getElementById('systemMode')


function classesToggle() {
    let active = localStorage.theme
    const switches = [darkMode, lightMode, systemMode]
    const storages = ['dark', 'light', undefined]

    storages.forEach((element, index) => {
        if (element == active) {
            switches[index].classList.add("active-switch-theme-mode")
            switches[index].classList.remove("inactive-switch-theme-mode")
        } else {
            switches[index].classList.remove("active-switch-theme-mode")
            switches[index].classList.add("inactive-switch-theme-mode")
        }
    })
}


window.addEventListener("load", (event) => {
    classesToggle()
})

// Funkcja changeMode() pochodzi z public\js\dark-mode.js
// Powód: żeby uniknąć efektu błyskania podczas przechodzenia między podstronami w trybie ciemnym
document.addEventListener('DOMContentLoaded', function () {

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
        changeMode()
        classesToggle()
    }, false)

    darkMode.addEventListener('click', function () {
        localStorage.theme = 'dark'
        changeMode()
        classesToggle()
    }, false)

    lightMode.addEventListener('click', function () {
        localStorage.theme = 'light'
        changeMode()
        classesToggle()
    }, false);

    systemMode.addEventListener('click', function () {
        localStorage.removeItem('theme')
        changeMode()
        classesToggle()
    }, false);

}, false)


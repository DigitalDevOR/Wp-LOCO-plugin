document.addEventListener('DOMContentLoaded', () => {

    const widgets = document.querySelectorAll('[data-widget-loco]');

    widgets.forEach((widget) => {

        const button = widget.querySelector('.widget-loco-button');

        if (!button) {
            return;
        }

        button.addEventListener('click', () => {

            console.log('Widget Loco');

            console.log(WidgetLoco);

            alert('Frontend JS caricato correttamente!');

        });

    });

});
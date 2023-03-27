(function ($, Drupal, drupalSettings) {
    'use strict';
    $('.timer__title').append(drupalSettings.countdown.timer_title.value);
    $('.timer__text').append(drupalSettings.countdown.timer_text.value);
    Drupal.behaviors.velesTimer = {
        attach: function (context) {
            let austDay = new Date(drupalSettings.countdown.unixtimestamp * 1000);
            $('#velesCountDown').countdown({
                until: austDay,
                format:'HMS',
                compact: true,
                layout:
                `<div class="timer__block">
                    <span class="timer__value value-timer-h">{h100}{h10}{h1}</span>
                        <span class="timer__key">Часов</span>
                    </div>` +
                `<div class="timer__separator">{sep}</div>` +

                `<div class="timer__block">
                    <span class="timer__value">{m10}{m1}</span>
                        <span class="timer__key">Минут</span>
                    </div>` +
                `<div class="timer__separator">{sep}</div>` +

                `<div class="timer__block">
                    <span class="timer__value">{s10}{s1}</span>
                            <span class="timer__key">Секунд</span>
                </div>`

            });
        }
    };
})(jQuery, Drupal, drupalSettings);

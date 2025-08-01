import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import marquee from './marquee';

window.Alpine = Alpine

Alpine.data('marquee', marquee);

Livewire.start()

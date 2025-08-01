export default function marquee() {
    return {
        position: 0,
        containerWidth: 0,
        textWidth: 0,
        speed: 1,
        interval: null,

        startAnimation() {
            this.$nextTick(() => {
                const container = this.$root;
                const text = this.$refs.text;
                this.containerWidth = container.offsetWidth;
                this.textWidth = text.offsetWidth;
                this.position = this.containerWidth;

                this.startInterval();
            });
        },

        startInterval() {
            this.interval = setInterval(() => {
                this.position -= this.speed;

                if (this.position < -this.textWidth) {
                    this.position = this.containerWidth;
                }
            }, 16);
        },

        pauseAnimation() {
            clearInterval(this.interval);
        },

        resumeAnimation() {
            this.startInterval();
        },
    };
}

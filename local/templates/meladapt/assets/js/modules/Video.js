'use strict';
/**
 * Подгрузка видео в блок
 */

class VideoLoader {
    constructor(element, options) {
        this.options = {};

        this.dataName = {
            videoLoad: 'video-load',
            videoContent: 'video-content'
        };

        this.$el = element || document.querySelectorAll(`[data-${this.dataName.videoLoad}]`);
        $.extend(true, this, this, options);

        this.init();
    }

    //Method for run all class methods
    init(){
        this.bindEvents();
    }

    //Method for all events
    bindEvents(){
        this.$el.forEach(($el) => {
            $el.addEventListener('click', this.loadVideo.bind(this));
        });
    }
    /**
     * Load video from youtube and insert it in inside parent element
     * @param e - event
     */
    loadVideo(e) {
        e.preventDefault();
        let $self = e.currentTarget,
            $parent = $self.closest(`[data-${this.dataName.videoContent}]`),
            videoID = $self.getAttribute(`data-${this.dataName.videoLoad}`),
            iframeHtml = `<iframe src="https://www.youtube.com/embed/${videoID}?autoplay=1" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
        $parent.innerHTML = '';

        $parent.insertAdjacentHTML('beforeend',iframeHtml);
    }

}

export default VideoLoader;
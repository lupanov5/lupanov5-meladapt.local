"use strict";

import HandyCollapse from "handy-collapse";

class Tabs {
    constructor() {}

    init(){
        const tab = new HandyCollapse({
            nameSpace: "tab",
            toggleButtonAttr: 'data-tab-btn',
            toggleContentAttr: 'data-tab-content',
            closeOthers: true,
            isAnimation: true
        });
        const use = new HandyCollapse({
            nameSpace: "use",
            toggleButtonAttr: 'data-use-btn',
            toggleContentAttr: 'data-use-content',
            activeClass: 'active',
            animationSpeed: 300,
            closeOthers: true,
            isAnimation: true
        });
    }
}

export default Tabs;


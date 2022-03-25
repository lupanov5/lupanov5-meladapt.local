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
    }
}

export default Tabs;


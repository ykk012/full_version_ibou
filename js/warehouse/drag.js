function drag(element, ev) {
    document.body.style.cursor = "move";

    document.onmousemove = function(ev) {
        ev = ev || window.event;
        var top = Event.pointerY(ev);
        var left = Event.pointerX(ev);
        element.style.position = "absolute";
        element.style.left = left + "px";
        element.style.top = top + "px";
        Event.stop(ev);
        return false;
    };

    document.onmouseup = function(ev) {
        ev = ev || window.event;
        document.body.style.cursor = "auto";

        // 필요한 작업 수행

        document.onmousemove = null;
        document.onmouseup = null;
        Event.stop(ev);
        return false;
    };
    Event.stop(ev);
    return false;
}
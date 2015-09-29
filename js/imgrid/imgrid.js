/*
 *  jQuery Image Grid - v1.0.0
 *  Just another Image Grid jQuery plugin
 *  
 *
 *  Made by Rabartu
 *  Under GPLv.3 License
 */


(function ($) {

    // for zeptojs;
    $.isNumeric == null && ($.isNumeric = function (src) {
        return src != null && src.constructor === Number;
    });

    $.isFunction == null && ($.isFunction = function (src) {
        return src != null && src instanceof Function;
    });

    var $W = $(window);
    var $D = $(document);

    var layoutManager = {
        // default setting;
        defaultConfig: {
            animate: false,
            cellW: 100, // function(container) {return 100;}
            cellH: 100, // function(container) {return 100;}
            delay: 0, // slowdown active block;
            engine: 'giot', // 'giot' is a person name;
            fixSize: null, // resize + adjust = fill gap;
            //fixSize: 0, resize but keep ratio = no fill gap;
            //fixSize: 1, no resize + no adjust = no fill gap;
            gutterX: 15, // width spacing between blocks;
            gutterY: 15, // height spacing between blocks;
            keepOrder: false,
            selector: '> div',
            draggable: false,
            cacheSize: true, // caches the original size of block;
            rightToLeft: false,
            bottomToTop: false,
            onGapFound: function () {
            },
            onComplete: function () {
            },
            onResize: function () {
            },
            onBlockDrag: function () {
            },
            onBlockMove: function () {
            },
            onBlockDrop: function () {
            },
            onBlockReady: function () {
            },
            onBlockFinish: function () {
            },
            onBlockActive: function () {
            },
            onBlockResize: function () {
            }
        },
        plugin: {},
        totalGrid: 1,
        transition: false,
        loadBlock: function (item, setting) {
            var runtime = setting.runtime;
            var gutterX = runtime.gutterX;
            var gutterY = runtime.gutterY;
            var cellH = runtime.cellH;
            var cellW = runtime.cellW;
            var block = null;
            var $item = $(item);
            var active = $item.data("active");
            var fixPos = $item.attr('data-position');
            var fixSize = parseInt($item.attr('data-fixSize'));
            var blockId = runtime.lastId++ + '-' + runtime.totalGrid;

            //ignore dragging block;
            if ($item.hasClass('fw-float')) return;
            $item.attr({id: blockId, 'data-delay': item.index});

            //remove animation for speed render;
            if (setting.animate && this.transition) {
                this.setTransition(item, "");
            }

            isNaN(fixSize) && (fixSize = null);
            (fixSize == null) && (fixSize = setting.fixSize);
            var makeRound = (fixSize >= 1) ? "ceil" : "round";
            // store original size;

            $item.attr('data-height') == null && $item.attr('data-height', $item.height());
            $item.attr('data-width') == null && $item.attr('data-width', $item.width());
            var height = 1 * $item.attr('data-height');
            var width = 1 * $item.attr('data-width');

            if (!setting.cacheSize) {
                item.style.width = "";
                width = $item.width();

                item.style.height = "";
                height = $item.height();
            }

            var col = !width ? 0 : Math[makeRound]((width + gutterX) / cellW);
            var row = !height ? 0 : Math[makeRound]((height + gutterY) / cellH);

            // estimate size;
            if (!fixSize && setting.cellH == 'auto') {
                $item.width(cellW * col - gutterX);
                item.style.height = "";
                height = $item.height();
                row = !height ? 0 : Math.round((height + gutterY) / cellH);
            }

            if (!fixSize && setting.cellW == 'auto') {
                $item.height(cellH * row - gutterY);
                item.style.width = "";
                width = $item.width();
                col = !width ? 0 : Math.round((width + gutterX) / cellW);
            }

            // for none resize block;
            if ((fixSize != null) && (col > runtime.limitCol || row > runtime.limitRow)) {
                block = null;
            } else {
                // get smallest width and smallest height of block;
                // using for image runtime;
                row && row < runtime.minHoB && (runtime.minHoB = row);
                col && col < runtime.minWoB && (runtime.minWoB = col);

                // get biggest width and biggest height of block;
                row > runtime.maxHoB && (runtime.maxHoB = row);
                col > runtime.maxWoB && (runtime.maxWoB = col);

                width == 0 && (col = 0);
                height == 0 && (row = 0);

                block = {
                    resize: false,
                    id: blockId,
                    width: col,
                    height: row,
                    fixSize: fixSize
                };

                // for fix position;
                if (fixPos) {
                    fixPos = fixPos.split("-");
                    block.y = 1 * fixPos[0];
                    block.x = 1 * fixPos[1];
                    block.width = fixSize != null ? col : Math.min(col, runtime.limitCol - block.x);
                    block.height = fixSize != null ? row : Math.min(row, runtime.limitRow - block.y);
                    var holeId = block.y + "-" + block.x + "-" + block.width + "-" + block.height;
                    if (active) {
                        runtime.holes[holeId] = {
                            id: block.id,
                            top: block.y,
                            left: block.x,
                            width: block.width,
                            height: block.height
                        };
                        this.setBlock(block, setting);
                    } else {
                        delete runtime.holes[holeId];
                    }

                }
            }

            // for css animation;
            if ($item.attr("data-state") == null) {
                $item.attr("data-state", "init");
            } else {
                $item.attr("data-state", "move");
            }

            setting.onBlockReady.call(item, block, setting);

            return (fixPos && active) ? null : block;
        },
        setBlock: function (block, setting) {
            var runtime = setting.runtime;
            var gutterX = runtime.gutterX;
            var gutterY = runtime.gutterY;
            var height = block.height;
            var width = block.width;
            var cellH = runtime.cellH;
            var cellW = runtime.cellW;
            var x = block.x;
            var y = block.y;

            if (setting.rightToLeft) {
                x = runtime.limitCol - x - width;
            }
            if (setting.bottomToTop) {
                y = runtime.limitRow - y - height;
            }

            var realBlock = {
                fixSize: block.fixSize,
                resize: block.resize,
                top: y * cellH,
                left: x * cellW,
                width: cellW * width - gutterX,
                height: cellH * height - gutterY
            };

            realBlock.top = 1 * realBlock.top.toFixed(2);
            realBlock.left = 1 * realBlock.left.toFixed(2);
            realBlock.width = 1 * realBlock.width.toFixed(2);
            realBlock.height = 1 * realBlock.height.toFixed(2);

            //runtime.length += 1;
            block.id && (runtime.blocks[block.id] = realBlock);

            // for append feature;
            return realBlock;
        },
        showBlock: function (item, setting) {
            var runtime = setting.runtime;
            var method = setting.animate && !this.transition ? 'animate' : 'css';
            var block = runtime.blocks[item.id];
            var $item = $(item);
            var self = this;
            var start = $item.attr("data-state") != "move";
            var trans = start ? "width 0.5s, height 0.5s" : "top 0.5s, left 0.5s, width 0.5s, height 0.5s, opacity 0.5s";

            item.delay && clearTimeout(item.delay);
            //ignore dragging block;
            if ($item.hasClass('fw-float')) return;

            // kill the old transition;
            self.setTransition(item, "");
            item.style.position = "absolute";
            setting.onBlockActive.call(item, block, setting);

            function action() {
                // start to arrange;
                start && $item.attr("data-state", "start");
                // add animation by using css3 transition;
                if (setting.animate && self.transition) {
                    //self.setTransition(item, trans);
                }

                // for hidden block;
                if (!block) {
                    //var position = $item.position(); <= make speed so slow;
                    var height = parseInt(item.style.height) || 0;
                    var width = parseInt(item.style.width) || 0;
                    var left = parseInt(item.style.left) || 0;
                    var top = parseInt(item.style.top) || 0;
                    if (setting.animate) {
                        $item.velocity(
                            {
                                left: left + width / 2,
                                top: top + height / 2,
                                width: 0,
                                height: 0

                            },
                            {
                                duration: 500,
                                queue: false,
                                easing: 'easeOutQuad'
                            });
                    } else {
                        $item.css(
                            {
                                left: left + width / 2,
                                top: top + height / 2,
                                width: 0,
                                height: 0

                            });
                    }

                } else {
                    if (block.fixSize) {
                        block.height = 1 * $item.attr("data-height");
                        block.width = 1 * $item.attr("data-width");
                    }

                    if (setting.animate && $item.hasClass('imgrid-animated')) {
                        $item.velocity(
                            {
                                top: block.top,
                                left: block.left,
                                width: block.width,
                                height: block.height,
                                opacity: 1
                            },
                            {
                                duration: 500,
                                queue: false,
                                easing: 'easeOutQuad'
                            });
                    } else {
                        $item.css(
                            {
                                top: block.top,
                                left: block.left,
                                width: block.width,
                                height: block.height,
                                opacity: 1
                            });
                    }


                    if ($item.attr('data-nested') != null) {
                        self.nestedGrid(item, setting);
                    }
                }

                runtime.length -= 1;

                setting.onBlockFinish.call(item, block, setting);

                runtime.length == 0 && setting.onComplete.call(item, block, setting);
            }

            block && block.resize && setting.onBlockResize.call(item, block, setting);

            setting.delay > 0 ? (item.delay = setTimeout(action, setting.delay * $item.attr("data-delay"))) : action();
        },
        nestedGrid: function (item, setting) {
            var innerWall, $item = $(item), runtime = setting.runtime;
            var gutterX = $item.attr("data-gutterX") || setting.gutterX;
            var gutterY = $item.attr("data-gutterY") || setting.gutterY;
            var method = $item.attr("data-method") || "fitZone";
            var nested = $item.attr('data-nested') || "> div";
            var cellH = $item.attr("data-cellH") || setting.cellH;
            var cellW = $item.attr("data-cellW") || setting.cellW;
            var block = runtime.blocks[item.id];

            if (block) {
                innerWall = new freewall($item);
                innerWall.reset({
                    cellH: cellH,
                    cellW: cellW,
                    gutterX: 1 * gutterX,
                    gutterY: 1 * gutterY,
                    selector: nested,
                    cacheSize: false
                });

                switch (method) {
                    case "fitHeight":
                        innerWall[method](block.height);
                        break;
                    case "fitWidth":
                        innerWall[method](block.width);
                        break;
                    case "fitZone":
                        innerWall[method](block.width, block.height);
                        break;
                }
            }
        },
        adjustBlock: function (block, setting) {
            var runtime = setting.runtime;
            var gutterX = runtime.gutterX;
            var gutterY = runtime.gutterY;
            var $item = $("#" + block.id);
            var cellH = runtime.cellH;
            var cellW = runtime.cellW;

            if (setting.cellH == 'auto') {
                $item.width(block.width * cellW - gutterX);
                $item[0].style.height = "";
                block.height = Math.round(($item.height() + gutterY) / cellH);
            }
        },
        adjustUnit: function (width, height, setting) {
            var gutterX = setting.gutterX;
            var gutterY = setting.gutterY;
            var runtime = setting.runtime;
            var cellW = setting.cellW;
            var cellH = setting.cellH;

            $.isFunction(cellW) && (cellW = cellW(width));
            cellW = 1 * cellW;
            !$.isNumeric(cellW) && (cellW = 1);

            $.isFunction(cellH) && (cellH = cellH(height));
            cellH = 1 * cellH;
            !$.isNumeric(cellH) && (cellH = 1);

            if ($.isNumeric(width)) {
                // adjust cell width via container;
                cellW < 1 && (cellW = cellW * width);

                // estimate total columns;
                var limitCol = Math.max(1, Math.floor(width / cellW));

                // adjust unit size for fit width;
                if (!$.isNumeric(gutterX)) {
                    gutterX = (width - limitCol * cellW) / Math.max(1, (limitCol - 1));
                    gutterX = Math.max(0, gutterX);
                }

                limitCol = Math.floor((width + gutterX) / cellW);
                runtime.cellW = (width + gutterX) / Math.max(limitCol, 1);
                runtime.cellS = runtime.cellW / cellW;
                runtime.gutterX = gutterX;
                runtime.limitCol = limitCol;
            }

            if ($.isNumeric(height)) {
                // adjust cell height via container;
                cellH < 1 && (cellH = cellH * height);

                // estimate total rows;
                var limitRow = Math.max(1, Math.floor(height / cellH));

                // adjust size unit for fit height;
                if (!$.isNumeric(gutterY)) {
                    gutterY = (height - limitRow * cellH) / Math.max(1, (limitRow - 1));
                    gutterY = Math.max(0, gutterY);
                }

                limitRow = Math.floor((height + gutterY) / cellH);
                runtime.cellH = (height + gutterY) / Math.max(limitRow, 1);
                runtime.cellS = runtime.cellH / cellH;
                runtime.gutterY = gutterY;
                runtime.limitRow = limitRow;
            }

            if (!$.isNumeric(width)) {
                // adjust cell width via cell height;
                cellW < 1 && (cellW = runtime.cellH);
                runtime.cellW = cellW != 1 ? cellW * runtime.cellS : 1;
                runtime.gutterX = gutterX;
                runtime.limitCol = 666666;
            }

            if (!$.isNumeric(height)) {
                // adjust cell height via cell width;
                cellH < 1 && (cellH = runtime.cellW);
                runtime.cellH = cellH != 1 ? cellH * runtime.cellS : 1;
                runtime.gutterY = gutterY;
                runtime.limitRow = 666666;
            }
        },
        resetGrid: function (runtime) {
            runtime.blocks = {};
            runtime.length = 0;
            runtime.cellH = 0;
            runtime.cellW = 0;
            runtime.lastId = 1;
            runtime.matrix = {};
            runtime.totalCol = 0;
            runtime.totalRow = 0;
        },
        setDraggable: function (item, option) {
            var isTouch = false;
            var config = {
                startX: 0, //start clientX;
                startY: 0,
                top: 0,
                left: 0,
                handle: null,
                onDrop: function () {
                },
                onDrag: function () {
                },
                onStart: function () {
                }
            };

            $(item).each(function () {
                var setting = $.extend({}, config, option);
                var handle = setting.handle || this;
                var ele = this;
                var $E = $(ele);
                var $H = $(handle);

                var posStyle = $E.css("position");
                posStyle != "absolute" && $E.css("position", "relative");


                function mouseDown(evt) {
                    evt.stopPropagation();
                    evt = evt.originalEvent;

                    if (evt.touches) {
                        isTouch = true;
                        evt = evt.changedTouches[0];
                    }

                    if (evt.button != 2 && evt.which != 3) {
                        setting.onStart.call(ele, evt);

                        setting.startX = evt.clientX;
                        setting.startY = evt.clientY;
                        setting.top = parseInt($E.css("top")) || 0;
                        setting.left = parseInt($E.css("left")) || 0;

                        $D.bind("mouseup touchend", mouseUp);
                        $D.bind("mousemove touchmove", mouseMove);
                    }

                    return false;
                };


                function mouseMove(evt) {
                    evt = evt.originalEvent;
                    isTouch && (evt = evt.changedTouches[0]);

                    $E.css({
                        top: setting.top - (setting.startY - evt.clientY),
                        left: setting.left - (setting.startX - evt.clientX)
                    });

                    setting.onDrag.call(ele, evt);
                };

                function mouseUp(evt) {
                    evt = evt.originalEvent;
                    isTouch && (evt = evt.changedTouches[0]);

                    setting.onDrop.call(ele, evt);

                    $D.unbind("mouseup touchend", mouseUp);
                    $D.unbind("mousemove touchmove", mouseMove);
                };

                // ignore drag drop on text field;
                $E.find("iframe, form, input, textarea, .ignore-drag")
                    .each(function () {
                        $(this).on("touchstart mousedown", function (evt) {
                            evt.stopPropagation();
                        });
                    });

                $D.unbind("mouseup touchend", mouseUp);
                $D.unbind("mousemove touchmove", mouseMove);
                $H.unbind("mousedown touchstart").bind("mousedown touchstart", mouseDown);

            });
        },
        setTransition: function (item, trans) {
            var style = item.style;
            var $item = $(item);

            // remove animation;
            if (!this.transition && $item.stop) {
                $item.stop();
            } else if (style.webkitTransition != null) {
                style.webkitTransition = trans;
            } else if (style.MozTransition != null) {
                style.MozTransition = trans;
            } else if (style.msTransition != null) {
                style.msTransition = trans;
            } else if (style.OTransition != null) {
                style.OTransition = trans;
            } else {
                style.transition = trans;
            }
        },
        getFreeArea: function (t, l, runtime) {
            var maxY = Math.min(t + runtime.maxHoB, runtime.limitRow);
            var maxX = Math.min(l + runtime.maxWoB, runtime.limitCol);
            var minX = maxX;
            var minY = maxY;
            var matrix = runtime.matrix;

            // find limit zone by horizon;
            for (var y = t; y < minY; ++y) {
                for (var x = l; x < maxX; ++x) {
                    if (matrix[y + '-' + x]) {
                        (l < x && x < minX) && (minX = x);
                    }
                }
            }

            // find limit zone by vertical;
            for (var y = t; y < maxY; ++y) {
                for (var x = l; x < minX; ++x) {
                    if (matrix[y + '-' + x]) {
                        (t < y && y < minY) && (minY = y);
                    }
                }
            }

            return {
                top: t,
                left: l,
                width: minX - l,
                height: minY - t
            };

        },
        setWallSize: function (runtime, container) {
            var totalRow = runtime.totalRow;
            var totalCol = runtime.totalCol;
            var gutterY = runtime.gutterY;
            var gutterX = runtime.gutterX;
            var cellH = runtime.cellH;
            var cellW = runtime.cellW;
            var totalWidth = Math.max(0, cellW * totalCol - gutterX);
            var totalHeight = Math.max(0, cellH * totalRow - gutterY);

            container.attr({
                'data-total-col': totalCol,
                'data-total-row': totalRow,
                'data-wall-width': Math.ceil(totalWidth),
                'data-wall-height': Math.ceil(totalHeight)
            });

            if (runtime.limitCol < runtime.limitRow) {
                // do not set height with nesting grid;
                !container.attr("data-height") && Math.ceil(totalHeight);
                container.velocity({height: Math.ceil(totalHeight)}, {
                    duration: 500,
                    queue: false,
                    easing: 'easeOutQuad'
                });
            }
        }
    };


    var engine = {
        // Giot just a person name;
        giot: function (items, setting) {
            var runtime = setting.runtime,
                row = runtime.limitRow,
                col = runtime.limitCol,
                x = 0,
                y = 0,
                maxX = runtime.totalCol,
                maxY = runtime.totalRow,
                wall = {},
                holes = runtime.holes,
                block = null,
                matrix = runtime.matrix,
                bigLoop = Math.max(col, row),
                freeArea = null,
                misBlock = null,
                fitWidth = col < row ? 1 : 0,
                lastBlock = null,
                smallLoop = Math.min(col, row);

            // fill area with top, left, width, height;
            function fillMatrix(id, t, l, w, h) {
                for (var y = t; y < t + h;) {
                    for (var x = l; x < l + w;) {
                        matrix[y + '-' + x] = id;
                        ++x > maxX && (maxX = x);
                    }
                    ++y > maxY && (maxY = y);
                }
            }

            // set holes on the wall;
            for (var i in holes) {
                if (holes.hasOwnProperty(i)) {
                    fillMatrix(holes[i]["id"] || true, holes[i]['top'], holes[i]['left'], holes[i]['width'], holes[i]['height']);
                }
            }


            for (var b = 0; b < bigLoop; ++b) {
                if (!items.length) break;
                fitWidth ? (y = b) : (x = b);
                lastBlock = null;

                for (var s = 0; s < smallLoop; ++s) {
                    if (!items.length) break;
                    block = null;
                    fitWidth ? (x = s) : (y = s);
                    if (runtime.matrix[y + '-' + x]) continue;
                    freeArea = layoutManager.getFreeArea(y, x, runtime);

                    // trying resize last block to fit free area;
                    if (setting.fixSize == null) {
                        // resize near block to fill gap;
                        if (lastBlock && !fitWidth && runtime.minHoB > freeArea.height) {
                            lastBlock.height += freeArea.height;
                            lastBlock.resize = true;
                            fillMatrix(lastBlock.id, lastBlock.y, lastBlock.x, lastBlock.width, lastBlock.height);
                            layoutManager.setBlock(lastBlock, setting);
                            continue;
                        } else if (lastBlock && fitWidth && runtime.minWoB > freeArea.width) {
                            lastBlock.width += freeArea.width;
                            lastBlock.resize = true;
                            fillMatrix(lastBlock.id, lastBlock.y, lastBlock.x, lastBlock.width, lastBlock.height);
                            layoutManager.setBlock(lastBlock, setting);
                            continue;
                        }
                    }

                    // get the next block to keep order;
                    if (setting.keepOrder) {
                        block = items.shift();
                        block.resize = true;
                    } else {
                        // find a suitable block to fit gap;
                        for (var i = 0; i < items.length; ++i) {
                            if (items[i].height > freeArea.height) continue;
                            if (items[i].width > freeArea.width) continue;
                            block = items.splice(i, 1)[0];
                            break;
                        }

                        // trying resize the other block to fit gap;
                        if (block == null && setting.fixSize == null) {
                            // get other block fill to gap;
                            for (var i = 0; i < items.length; ++i) {
                                if (items[i]['fixSize'] != null) continue;
                                block = items.splice(i, 1)[0];
                                block.resize = true;
                                break;
                            }

                        }
                    }


                    if (block != null) {
                        // resize block with free area;
                        if (block.resize) {
                            if (fitWidth) {
                                block.width = freeArea.width;
                                if (setting.cellH == 'auto') {
                                    layoutManager.adjustBlock(block, setting);
                                }
                                // for fitZone;
                                block.height = Math.min(block.height, freeArea.height);
                            } else {
                                block.height = freeArea.height;
                                // for fitZone;
                                block.width = Math.min(block.width, freeArea.width);
                            }
                        }

                        wall[block.id] = {
                            id: block.id,
                            x: x,
                            y: y,
                            width: block.width,
                            height: block.height,
                            resize: block.resize,
                            fixSize: block.fixSize
                        };

                        // keep success block for next round;
                        lastBlock = wall[block.id];

                        fillMatrix(lastBlock.id, lastBlock.y, lastBlock.x, lastBlock.width, lastBlock.height);
                        layoutManager.setBlock(lastBlock, setting);
                    } else {
                        // get expect area;
                        var misBlock = {
                            x: x,
                            y: y,
                            fixSize: 0
                        };
                        if (fitWidth) {
                            misBlock.width = freeArea.width;
                            misBlock.height = 0;
                            var lastX = x - 1;
                            var lastY = y;

                            while (matrix[lastY + '-' + lastX]) {
                                matrix[lastY + '-' + x] = true;
                                misBlock.height += 1;
                                lastY += 1;
                            }
                        } else {
                            misBlock.height = freeArea.height;
                            misBlock.width = 0;
                            var lastY = y - 1;
                            var lastX = x;

                            while (matrix[lastY + '-' + lastX]) {
                                matrix[y + '-' + lastX] = true;
                                misBlock.width += 1;
                                lastX += 1;
                            }
                        }
                        setting.onGapFound(layoutManager.setBlock(misBlock, setting), setting);
                    }
                }

            }

            runtime.matrix = matrix;
            runtime.totalRow = maxY;
            runtime.totalCol = maxX;
        }
    };


    window.freewall = function (selector) {

        var container = $(selector);
        if (container.css('position') == 'static') {
            container.css('position', 'relative');
        }
        var MAX = Number.MAX_VALUE;
        var klass = this;
        // increase the instance index;
        layoutManager.totalGrid += 1;

        var setting = $.extend({}, layoutManager.defaultConfig);
        var runtime = {
            blocks: {}, // store all items;
            events: {}, // store custome events;
            matrix: {},
            holes: {}, // forbidden zone;

            cellW: 0,
            cellH: 0, // unit adjust;
            cellS: 1, // unit scale;

            filter: '', // filter selector;

            lastId: 0,
            length: 0,

            maxWoB: 0, // max width of block;
            maxHoB: 0,
            minWoB: MAX,
            minHoB: MAX, // min height of block;

            running: 0, // flag to check layout arranging;

            gutterX: 15,
            gutterY: 15,

            totalCol: 0,
            totalRow: 0,

            limitCol: 666666, // maximum column; 
            limitRow: 666666,

            currentMethod: null,
            currentArguments: []
        };
        setting.runtime = runtime;
        runtime.totalGrid = layoutManager.totalGrid;

        // check browser support transition;
        var bodyStyle = document.body.style;
        if (!layoutManager.transition) {
            (bodyStyle.webkitTransition != null ||
                bodyStyle.MozTransition != null ||
                bodyStyle.msTransition != null ||
                bodyStyle.OTransition != null ||
                bodyStyle.transition != null) &&
            (layoutManager.transition = true);
        }


        function setDraggable(item) {

            var gutterX = runtime.gutterX;
            var gutterY = runtime.gutterY;
            var cellH = runtime.cellH;
            var cellW = runtime.cellW;
            var $item = $(item);
            var handle = $item.find($item.attr("data-handle"));
            layoutManager.setDraggable(item, {
                handle: handle[0],
                onStart: function (event) {
                    if (setting.animate && layoutManager.transition) {
                        layoutManager.setTransition(this, "");
                    }
                    $item.css('z-index', 9999).addClass('fw-float');

                    setting.onBlockDrag.call(item, event);
                },
                onDrag: function (event, tracker) {
                    var position = $item.position();
                    var top = Math.round(position.top / cellH);
                    var left = Math.round(position.left / cellW);
                    var width = Math.round($item.width() / cellW);
                    var height = Math.round($item.height() / cellH);
                    top = Math.min(Math.max(0, top), runtime.limitRow - height);
                    left = Math.min(Math.max(0, left), runtime.limitCol - width);
                    klass.setHoles({top: top, left: left, width: width, height: height});
                    klass.refresh();

                    setting.onBlockMove.call(item, event);
                },
                onDrop: function (event) {
                    var position = $item.position();
                    var top = Math.round(position.top / cellH);
                    var left = Math.round(position.left / cellW);
                    var width = Math.round($item.width() / cellW);
                    var height = Math.round($item.height() / cellH);
                    top = Math.min(Math.max(0, top), runtime.limitRow - height);
                    left = Math.min(Math.max(0, left), runtime.limitCol - width);

                    $item.removeClass('fw-float');
                    $item.css({
                        zIndex: "auto",
                        top: top * cellH,
                        left: left * cellW
                    });

                    //check old drag element;
                    var x, y, key, oldDropId;
                    for (y = 0; y < height; ++y) {
                        for (x = 0; x < width; ++x) {
                            key = (y + top) + "-" + (x + left);
                            oldDropId = runtime.matrix[key];
                            if (oldDropId && oldDropId != true) {
                                $("#" + oldDropId).removeAttr("data-position");
                            }
                        }
                    }

                    runtime.holes = {};

                    $item.attr({
                        "data-width": $item.width(),
                        "data-height": $item.height(),
                        "data-position": top + "-" + left
                    });

                    klass.refresh();

                    setting.onBlockDrop.call(item, event);
                }
            });
        }


        $.extend(klass, {

            addCustomEvent: function (name, func) {
                var events = runtime.events;
                name = name.toLowerCase();
                !events[name] && (events[name] = []);
                func.eid = events[name].length;
                events[name].push(func);
                return this;
            },

            appendBlock: function (items) {
                var allBlock = $(items).appendTo(container);
                var block = null;
                var activeBlock = [];

                if (runtime.currentMethod) {
                    allBlock.each(function (index, item) {
                        item.index = ++index;
                        block = layoutManager.loadBlock(item, setting);
                        block && activeBlock.push(block);
                    });

                    engine[setting.engine](activeBlock, setting);

                    layoutManager.setWallSize(runtime, container);

                    runtime.length = allBlock.length;

                    allBlock.each(function (index, item) {
                        layoutManager.showBlock(item, setting);
                        if (setting.draggable || item.getAttribute('data-draggable')) {
                            setDraggable(item);
                        }
                    });
                }
            },
            /*
             add one or more blank area (hole) on layout;
             example:

             wall.appendHoles({
             top: 10,
             left: 36,
             width: 2,
             height: 6
             });

             wall.appendHoles([
             {
             top: 16,
             left: 16,
             width: 8,
             height: 2
             },
             {
             top: 10,
             left: 36,
             width: 2,
             height: 6
             }
             ]);

             */
            appendHoles: function (holes) {
                var newHoles = [].concat(holes), h = {}, i;
                for (i = 0; i < newHoles.length; ++i) {
                    h = newHoles[i];
                    runtime.holes[h.top + "-" + h.left + "-" + h.width + "-" + h.height] = h;
                }
                return this;
            },

            container: container,

            destroy: function () {
                var allBlock = container.find(setting.selector).removeAttr('id'),
                    block = null,
                    activeBlock = [];

                allBlock.each(function (index, item) {
                    $item = $(item);
                    var width = 1 * $item.attr('data-width') || "";
                    var height = 1 * $item.attr('data-height') || "";
                    $item.width(width).height(height).css({
                        position: 'static'
                    });
                });
            },

            fillHoles: function (holes) {
                if (arguments.length == 0) {
                    runtime.holes = {};
                } else {
                    var newHoles = [].concat(holes), h = {}, i;
                    for (i = 0; i < newHoles.length; ++i) {
                        h = newHoles[i];
                        delete runtime.holes[h.top + "-" + h.left + "-" + h.width + "-" + h.height];
                    }
                }
                return this;
            },

            filter: function (filter) {
                runtime.filter = filter;
                runtime.currentMethod && this.refresh();
                return this;
            },

            fireEvent: function (name, object, setting) {
                var events = runtime.events;
                name = name.toLowerCase();
                if (events[name] && events[name].length) {
                    for (var i = 0; i < events[name].length; ++i) {
                        events[name][i].call(this, object, setting);
                    }
                }
                return this;
            },

            fitHeight: function (height) {
                var allBlock = container.find(setting.selector).removeAttr('id'),
                    block = null,
                    activeBlock = [];

                height = height ? height : container.height() || $W.height();

                runtime.currentMethod = arguments.callee;
                runtime.currentArguments = arguments;

                layoutManager.resetGrid(runtime);
                layoutManager.adjustUnit('auto', height, setting);

                if (runtime.filter) {
                    allBlock.data('active', 0);
                    allBlock.filter(runtime.filter).data('active', 1);
                } else {
                    allBlock.data('active', 1);
                }

                allBlock.each(function (index, item) {
                    var $item = $(item);
                    item.index = ++index;
                    block = layoutManager.loadBlock(item, setting);
                    block && $item.data("active") && activeBlock.push(block);
                });

                klass.fireEvent('onGridReady', container, setting);

                engine[setting.engine](activeBlock, setting);

                layoutManager.setWallSize(runtime, container);

                klass.fireEvent('onGridArrange', container, setting);

                runtime.length = allBlock.length;

                allBlock.each(function (index, item) {
                    layoutManager.showBlock(item, setting);
                    if (setting.draggable || item.getAttribute('data-draggable')) {
                        setDraggable(item);
                    }
                });
            },

            fitWidth: function (width) {
                var allBlock = container.find(setting.selector).removeAttr('id'),
                    block = null,
                    activeBlock = [];

                width = width ? width : container.width() || $W.width();

                runtime.currentMethod = arguments.callee;
                runtime.currentArguments = arguments;

                layoutManager.resetGrid(runtime);
                layoutManager.adjustUnit(width, 'auto', setting);

                if (runtime.filter) {
                    allBlock.data('active', 0);
                    allBlock.filter(runtime.filter).data('active', 1);
                } else {
                    allBlock.data('active', 1);
                }

                allBlock.each(function (index, item) {
                    var $item = $(item);
                    item.index = ++index;
                    block = layoutManager.loadBlock(item, setting);
                    block && $item.data("active") && activeBlock.push(block);
                });

                klass.fireEvent('onGridReady', container, setting);

                engine[setting.engine](activeBlock, setting);

                layoutManager.setWallSize(runtime, container);

                klass.fireEvent('onGridArrange', container, setting);

                runtime.length = allBlock.length;

                allBlock.each(function (index, item) {
                    layoutManager.showBlock(item, setting);
                    if (setting.draggable || item.getAttribute('data-draggable')) {
                        setDraggable(item);
                    }
                });
            },

            fitZone: function (width, height) {
                var allBlock = container.find(setting.selector).removeAttr('id'),
                    block = null,
                    activeBlock = [];

                height = height ? height : container.height() || $W.height();
                width = width ? width : container.width() || $W.width();

                runtime.currentMethod = arguments.callee;
                runtime.currentArguments = arguments;

                layoutManager.resetGrid(runtime);
                layoutManager.adjustUnit(width, height, setting);

                if (runtime.filter) {
                    allBlock.data('active', 0);
                    allBlock.filter(runtime.filter).data('active', 1);
                } else {
                    allBlock.data('active', 1);
                }

                allBlock.each(function (index, item) {
                    var $item = $(item);
                    item.index = ++index;
                    block = layoutManager.loadBlock(item, setting);
                    block && $item.data("active") && activeBlock.push(block);
                });

                klass.fireEvent('onGridReady', container, setting);

                engine[setting.engine](activeBlock, setting);

                layoutManager.setWallSize(runtime, container);

                klass.fireEvent('onGridArrange', container, setting);

                runtime.length = allBlock.length;

                allBlock.each(function (index, item) {
                    layoutManager.showBlock(item, setting);
                    if (setting.draggable || item.getAttribute('data-draggable')) {
                        setDraggable(item);
                    }
                });
            },

            /*
             set block with special position, the top and left are multiple of unit width/height;
             example:

             wall.fixPos({
             top: 0,
             left: 0,
             block: $('.free')
             });
             */
            fixPos: function (option) {
                $(option.block).attr({'data-position': option.top + "-" + option.left});
                return this;
            },

            /*
             set block with special size, the width and height are multiple of unit width/height;
             example:

             wall.fixSize({
             height: 5,
             width: 2,
             block: $('.free')
             });
             */
            fixSize: function (option) {
                option.height != null && $(option.block).attr({'data-height': option.height});
                option.width != null && $(option.block).attr({'data-width': option.width});
                return this;
            },

            prepend: function (items) {
                container.prepend(items);
                runtime.currentMethod && this.refresh();
                return this;
            },

            refresh: function () {
                var params = arguments.length ? arguments : runtime.currentArguments;
                runtime.currentMethod == null && (runtime.currentMethod = this.fitWidth);
                runtime.currentMethod.apply(this, Array.prototype.slice.call(params, 0));
                return this;
            },

            /*
             custom layout setting;
             example:

             wall.reset({
             selector: '.brick',
             animate: true,
             cellW: 160,
             cellH: 160,
             delay: 50,
             onResize: function() {
             wall.fitWidth();
             }
             });
             */
            reset: function (option) {
                $.extend(setting, option);
                return this;
            },

            /*
             create one or more blank area (hole) on layout;
             example:

             wall.setHoles({
             top: 2,
             left: 2,
             width: 2,
             height: 2
             });
             */

            setHoles: function (holes) {
                var newHoles = [].concat(holes), h = {}, i;
                runtime.holes = {};
                for (i = 0; i < newHoles.length; ++i) {
                    h = newHoles[i];
                    runtime.holes[h.top + "-" + h.left + "-" + h.width + "-" + h.height] = h;
                }
                return this;
            },

            unFilter: function () {
                delete runtime.filter;
                this.refresh();
                return this;
            }
        });

        container.attr('data-min-width', Math.floor($W.width() / 80) * 80);
        // execute plugins;
        for (var i in layoutManager.plugin) {
            if (layoutManager.plugin.hasOwnProperty(i)) {
                layoutManager.plugin[i].call(klass, setting, container);
            }
        }

        // setup resize event;
        $W.resize(function () {
            if (runtime.running) return;
            runtime.running = 1;
            setTimeout(function () {
                runtime.running = 0;
                setting.onResize.call(klass, container);
            }, 122);
            container.attr('data-min-width', Math.floor($W.width() / 80) * 80);
        });
    };

    /*
     add default setting;
     example:

     freewall.addConfig({
     offsetLeft: 0
     });
     */
    freewall.addConfig = function (newConfig) {
        // add default setting;
        $.extend(layoutManager.defaultConfig, newConfig);
    };


    /*
     support create new arrange algorithm;
     example:

     freewall.createEngine({
     slice: function(items, setting) {
     // slice engine;
     }
     });
     */
    freewall.createEngine = function (engineData) {
        // create new engine;
        $.extend(engine, engineData);
    };

    /*
     support create new plugin;
     example:

     freewall.createPlugin({
     centering: function(setting, container) {
     console.log(this);
     console.log(setting);
     }
     })l
     */
    freewall.createPlugin = function (pluginData) {
        // register new plugin;
        $.extend(layoutManager.plugin, pluginData);
    };

    /*
     support access helper function;
     example:

     freewall.getMethod('setBlock')(block, setting);
     */
    freewall.getMethod = function (method) {
        // get helper method;
        return layoutManager[method];
    };

})(window.Zepto || window.jQuery);

(function ($, window, document, undefined) {

    var pluginName = 'imgrid',
        defaults = {
            gridLayout: 'square',
            gridLoader: true,
            gridAnimation: {
                trigger: 'onStart', //Suport onStart | onScroll
                animationType: 'fade',
                animationDuration: 1000,
                delay: true,    // Successively delay the animation of each element in a set by the targeted amount
                offsetTop: 250, // Distance in pixels from the lower edge of the window and the top edge of the row that must exist before running the animation..
                timeout: 0      // Wait a certain time before running the row animation.
            },
            thumbSize: 'auto',
            thumbMargin: 0,
            thumbCacheSize: true,
            thumbHoverEffect: 'lily',
            thumbBackground: null,
            thumbReziseImg: true,
            thumbAnimation: true,
            thumbLightbox: true
        };

    // The actual plugin constructor
    function Plugin(element, options) {

        this.element = element;
        this.e_original = $(element).clone(); //keep a copy of  the original element
        this.options = $.extend({}, defaults, options);

        this._defaults = defaults;
        this._name = pluginName;

        this.wall = {};
        this.addedCount = 0;
        this.loader = {};
        this.rowsTops = [];
        this.rowIndex = 0;
        this.thumbIndex = 0;

        // Set states
        this.loaded = false;
        this.filtered = false;

        // Initialize
        this.init();

    }

    // Private Methods
    // ===============

    function _getMaxPossibleSize(jqObj, options) {
        var maxSize = 0;
        if (options.thumbSize === 'auto') {
            jqObj.find('figure img').each(function () {
                if (options.gridLayout === 'square' || options.gridLayout === 'masonry') {
                    if (maxSize > parseInt($(this).css('width'), 10) || maxSize === 0) {
                        maxSize = parseInt($(this).css('width'), 10);
                        if (maxSize > jqObj.width()) {
                            maxSize = jqObj.width() / 2;
                        }
                    }
                }
                if (options.gridLayout === 'square' || options.gridLayout === 'fluid') {
                    if (maxSize > parseInt($(this).css('height'), 10) || maxSize === 0) {
                        maxSize = parseInt($(this).css('height'), 10);
                        if (maxSize > jqObj.height()) {
                            maxSize = jqObj.height() / 2;
                        }
                    }
                }

            });

            if (options.gridLayout === 'fit') {
                var l = jqObj.find('figure').length;
                maxSize = Math.round(Math.sqrt(parseInt(jqObj.css('width'), 10) * parseInt(jqObj.css('height'), 10) / l) * 1.18);
            }
        } else {
            maxSize = options.thumbSize;
        }

        return maxSize;
    }

    function _addLoader(plugin, position) {
        if (typeof(plugin.options.gridLoader) === 'string') {
            plugin.loader = $(plugin.options.gridLoader);
        } else if (plugin.options.gridLoader) {
            plugin.loader = $(
                '<div class="imgrid-loader">' +
                '<span class="imgrid-loader-block"></span>' +
                '<span class="imgrid-loader-block"></span>' +
                '<span class="imgrid-loader-block"></span>' +
                '<span class="imgrid-loader-block"></span>' +
                '<span class="imgrid-loader-block"></span>' +
                '<span class="imgrid-loader-block"></span>' +
                '<span class="imgrid-loader-block"></span>' +
                '<span class="imgrid-loader-block"></span>' +
                '<span class="imgrid-loader-block"></span>' +
                '</div>'
            );
        }


        if (position === 'top') {
            //$(plugin.element).prepend(plugin.loader);
            plugin.loader.insertBefore($(plugin.element));
        }

        if (position === 'bottom') {
            //$(plugin.element).append(plugin.loader);
            plugin.loader.insertAfter($(plugin.element));
        }


    }

    function _removeLoader(plugin) {
        plugin.loader.remove();
    }

    function _thumbSetup($thumbnails, options, maxSize, container) {

        var $img;

        if (options.thumbBackground) {
            $thumbnails.css('background', options.thumbBackground);
        }

        if (options.thumbReziseImg) {
            $thumbnails.find('img').css('width', ' -webkit-calc(100%)').css('width', 'calc(100%)');
        }

        switch (options.gridLayout) {
            case 'square':
                $thumbnails.each(function () {
                    $img = $(this).find('img');
                    $img.data('original-width', $img.width()).data('original-height', $img.height());
                    $(this).css('width', maxSize + 'px').css('height', maxSize + 'px');
                });
                break;

            case 'fluid':
                $thumbnails.each(function () {
                    $img = $(this).find('img');
                    $img.data('original-width', $img.width()).data('original-height', $img.height());
                    var s = parseInt($img.css('width'), 10) / parseInt($img.css('height'), 10);
                    $(this).css('width', maxSize * s + 'px').css('height', maxSize + 'px');
                });
                break;

            case 'masonry':
                $thumbnails.each(function () {
                    $img = $(this).find('img');
                    $img.data('original-width', $img.width()).data('original-height', $img.height());
                    var s = parseInt($img.css('width'), 10) / parseInt($img.css('height'), 10);
                    $(this).css('width', maxSize + 'px').css('height', (maxSize / s) + 'px');
                });
                break;

            case 'fit':
                var ms = _getMaxPossibleSize(container, options);
                var g = (options.thumbMargin / 2);

                $thumbnails.each(function () {
                    $img = $(this).find('img');
                    $img.data('original-width', $img.width()).data('original-height', $img.height());
                    var tw = parseInt($img.css('width'), 10);
                    var th = parseInt($img.css('height'), 10);
                    var s;
                    //ms = 175;
                    if (tw > th) {
                        s = th / tw;
                        $(this).css('width', (ms - g) + 'px').css('height', (ms * s - g) + 'px');
                    } else {
                        s = tw / th;
                        $(this).css('width', (ms * s - g) + 'px').css('height', (ms - g) + 'px');
                    }
                });
                break;
        }

        return $thumbnails;
    }

    function _domSetup(jqObj, options) {
        var maxSize = _getMaxPossibleSize(jqObj, options);
        var $this = jqObj.find('figure');

        jqObj.addClass('imgrid');

        if (options.gridAnimation) {
            jqObj.css('opacity', 0);
        }

        if (!$this.hasClass('imgrid-thumbnail')) {
            $this.addClass('imgrid-thumbnail effect-' + options.thumbHoverEffect);
            if (options.gridAnimation === false) {
                $this.addClass('imgrid-animated');
            } else {
                $this.css('opacity', 0);
            }
        }

        _thumbSetup($this, options, maxSize, jqObj);

    }

    Plugin.prototype._onScroll = function () {

        var $window = $(window),
            win_height = $window.height();
        var scrolled = $window.scrollTop();
        var $trigger = $(this.element);
        var plugin = this;
        var options = this.options;
        var $notAnimated = $trigger.find('figure:not(.imgrid-animated)');

        if (scrolled + win_height - options.gridAnimation.offsetTop > $trigger.offset().top + plugin.rowsTops[plugin.rowIndex]) {
            $notAnimated = $trigger.find('figure.imgrid-row-' + plugin.rowIndex + ':not(.imgrid-animated)');
            var animOpts = {duration: options.gridAnimation.animationDuration};
            if (options.gridAnimation.delay) {
                var s = parseInt(options.gridAnimation.animationDuration / $notAnimated.length, 10);
                animOpts = {stagger: s, drag: true, duration: options.gridAnimation.animationDuration};
            }

            $notAnimated
                .velocity('transition.' + options.gridAnimation.animationType + 'In', animOpts)
                .delay(options.gridAnimation.timeout)
                .addClass('imgrid-animated');

            plugin.rowIndex = plugin.rowIndex + 1;
        }
    };

    function _animateOnScroll(plugin, options) {

        //Return if no animations setup
        if (!options.gridAnimation && options.gridAnimation.trigger !== 'onScroll') {
            return;
        }

        // Call before scroll to make first animation
        plugin._onScroll();

        $(window).on('scroll', function () {
            plugin._onScroll();
        });


    }

    function _onComplete(plugin) {
        var e;

        if (plugin.options.gridAnimation === false) {
            plugin.loaded = true;
            _removeLoader(plugin);
            e = $.Event('imgrid.loaded');
            $(plugin.element).trigger(e);
        }

        e = $.Event('imgrid.ready');
        $(plugin.element).trigger(e);

        if (!e.isDefaultPrevented()) {
            plugin.resizeCaption({maxFontSize: 3, widthToHide: 150});
        }
    }

    function _onLoaded(plugin) {
        plugin.loaded = true;
        $(plugin.element).css('opacity', '');
        _removeLoader(plugin);
        _animateOnScroll(plugin, plugin.options);
        var e = $.Event('imgrid.loaded');
        $(plugin.element).trigger(e);
    }

    /**
     *
     *
     * @param plugin
     * @param item
     * @param options
     * @private
     */
    function _onBlockFinish(plugin, item, options) {

        if (options.gridAnimation === false) {
            return;
        }

        var numItems = $(plugin.element).find('figure').length;
        var animOpts = {duration: options.gridAnimation.animationDuration};
        var customStagger;
        plugin.thumbIndex = plugin.thumbIndex + 1;
        if (!plugin.loaded) {
            if ($.inArray(item.top, plugin.rowsTops) === -1) {
                plugin.rowsTops.push(parseInt(item.top, 10));
            }

            if (numItems === plugin.thumbIndex) { //check if all items are loaded
                if (options.gridAnimation.trigger === 'onScroll') {
                    $(plugin.element).find('figure:not(.imgrid-animated)').each(function () {
                        var topIndex = $.inArray(parseInt($(this).css('top'), 10), plugin.rowsTops);

                        if (topIndex !== -1) {
                            $(this).addClass('imgrid-row-' + topIndex);
                        }
                        $(this).css('display', 'none');
                    });
                }

                if (options.gridAnimation.trigger === 'onStart') {
                    var $thumbs = $(plugin.element).find('figure:not(.imgrid-animated)');

                    if (options.gridAnimation.delay) {
                        customStagger = parseInt(options.gridAnimation.animationDuration / ($thumbs.length / 4), 10);
                        animOpts = {
                            stagger: customStagger,
                            drag: true,
                            duration: options.gridAnimation.animationDuration
                        };
                    }
                    $thumbs.css('display', 'none');

                    setTimeout(function () {
                        $thumbs.velocity('transition.' + options.gridAnimation.animationType + 'In', animOpts)
                            .delay(options.gridAnimation.timeout + options.gridAnimation.animationDuration)
                            .addClass('imgrid-animated');
                    }, 500);
                }


                plugin.thumbIndex = 0; //reset items counter
                _onLoaded(plugin); //call on loaded event

            }
        }
        else {
            if (plugin.addedCount !== 0 && plugin.addedCount === plugin.thumbIndex) {
                var $added = $(plugin.element).find('figure:not(.imgrid-animated)');
                if (options.gridAnimation.delay) {
                    customStagger = parseInt(options.gridAnimation.animationDuration / $added.length, 10);
                    animOpts = {stagger: customStagger, drag: true, duration: options.gridAnimation.animationDuration};
                }
                $added.css('display', 'none');

                setTimeout(function () {
                    $added.velocity('transition.' + options.gridAnimation.animationType + 'In', animOpts)
                        .delay(options.gridAnimation.timeout + options.gridAnimation.animationDuration)
                        .addClass('imgrid-animated');

                    plugin.wall.filter(plugin.filtered); //Call filter function if the item is filtered

                    plugin.addedCount = 0; //reset added tumbnails counter

                    plugin.thumbIndex = 0; //reset items counter
                    _onLoaded(plugin); //call on loaded event
                }, 500);

            }
            if (plugin.thumbIndex === numItems) {
                plugin.thumbIndex = 0; //reset items counter
            }
        }
    }

    function _lightBox(plugin, options) {

        var overlayActive = false;
        var doneAnimating = true;
        var inDuration = 275;
        var outDuration = 200;

        var $thumb = {}, $figcaption, figcaptionOriginal = {};

        $(plugin.element).on('click', 'figure', function () {

            $thumb = $(this);
            // If already modal, return to original
            if (doneAnimating === false) {
                return false;
            }
            else if (overlayActive && doneAnimating === true) {
                returnToOriginal($thumb);
                return false;
            }

            $figcaption = $thumb.find('figcaption');
            var windowWidth = window.innerWidth;
            var windowHeight = window.innerHeight;
            var originalWidth = $thumb.width();
            var originalHeight = $thumb.height();
            var imgOriginalWidth = $thumb.find('img').data('original-width');
            var imgOriginalHeight = $thumb.find('img').data('original-height');
            figcaptionOriginal = {
                top: $figcaption.css('top'),
                color: $figcaption.css('color'),
                fontWeight: $figcaption.css('font-weight'),
                fontSize: $figcaption.css('font-size'),
                displayH: $figcaption.find('h2').css('display'),
                displayD: $figcaption.find('.description').css('display')
            };
            var originalTop = $thumb.css('top');
            var originalLeft = $thumb.css('left');


            // Set states
            doneAnimating = false;
            $thumb.addClass('active');
            overlayActive = true;

            // Set css on origin
            $thumb.css({'z-index': 1000})
                .data('width', originalWidth)
                .data('height', originalHeight)
                .data('top', originalTop)
                .data('left', originalLeft);

            // Add overlay
            var overlay = $('<div id="imgrid-lightbox-overlay"></div>')
                .css({
                    opacity: 0
                })
                .click(function () {
                    if (doneAnimating === true) {
                        returnToOriginal($thumb);
                    }
                });

            // Animate Overlay
            $('body').append(overlay);
            overlay.velocity({opacity: 0.75}, {duration: inDuration, queue: false, easing: 'easeOutQuad'}
            );

            // Resize element
            var ratio = 0;
            var widthPercent = imgOriginalWidth / windowWidth;
            var heightPercent = imgOriginalHeight / windowHeight;
            var newWidth = 0;
            var newHeight = 0;

            if (widthPercent > heightPercent) {
                ratio = imgOriginalHeight / imgOriginalWidth;
                newWidth = windowWidth * 0.8;
                newHeight = windowWidth * 0.8 * ratio;
            }
            else {
                ratio = imgOriginalWidth / imgOriginalHeight;
                newWidth = (windowHeight * 0.8) * ratio;
                newHeight = windowHeight * 0.8;
            }
            // Animate element + set z-index
            $thumb
                .css('left', originalLeft)
                .css('top', originalTop)
                .css('box-shadow', '0px 16px 28px 0px rgba(0, 0, 0, 0.22), 0px 25px 55px 0px rgba(0, 0, 0, 0.21)')
                .css('overflow', 'visible')
                .removeClass('effect-' + options.thumbHoverEffect)
                .velocity(
                {
                    left: $(document).scrollLeft() + windowWidth / 2 - $thumb.parent('.imgrid').offset().left - newWidth / 2,
                    top: $(document).scrollTop() + windowHeight / 2 - $thumb.parent('.imgrid').offset().top - newHeight / 2,
                    height: newHeight,
                    width: newWidth

                },
                {
                    duration: inDuration,
                    queue: false,
                    easing: 'easeOutQuad',
                    complete: function () {
                        $(this).find('img').css('opacity', 1);
                        $figcaption.css('top', newHeight - 25 + 'px')
                            .css('color', '#bebec0').css('font-weight', 600)
                            .css('font-size', '16px');
                        $figcaption.find('h2').css('display', 'block');
                        $figcaption.find('.description').css('display', 'block');

                        doneAnimating = true;
                    }
                }
            ); // End Velocity


        }); // End on click

        // Return on scroll
        $(window).scroll(function () {
            if (overlayActive) {
                returnToOriginal($thumb);
            }
        });

        // Return on ESC
        $(document).keyup(function (e) {
            if (e.keyCode === 27 && doneAnimating === true) {   // ESC key
                if (overlayActive) {
                    returnToOriginal($thumb);
                }
            }
        });


        // This function returns the modaled image to the original spot
        function returnToOriginal($thumb) {

            doneAnimating = false;

            $('#imgrid-lightbox-overlay').fadeOut(outDuration, function () {
                // Remove Overlay
                overlayActive = false;
                $(this).remove();
            });

            // Resize Image
            $thumb.velocity(
                {
                    width: $thumb.data('width'),
                    height: $thumb.data('height'),
                    left: $thumb.data('left'),
                    top: $thumb.data('top')
                },
                {
                    duration: outDuration,
                    queue: false, easing: 'easeOutQuad',
                    complete: function () {
                        $figcaption
                            .css('top', '')
                            .css('color', '')
                            .css('font-weight', figcaptionOriginal.fontWeight)
                            .css('font-size', figcaptionOriginal.fontSize);
                        $figcaption.find('h2').css('display', figcaptionOriginal.displayH);
                        $figcaption.find('.description').css('display', figcaptionOriginal.displayD);
                        $thumb.css({
                            'z-index': '',
                            'box-shadow': 'none',
                            'overflow': 'hidden'
                        }).addClass('effect-' + options.thumbHoverEffect);
                        $thumb.find('img').css('opacity', '');

                        // Remove class
                        $thumb.removeClass('active');
                        doneAnimating = true;
                    }
                }
            );

        }
    }

    var _layout = {
        square: function (plugin, options) {
            plugin.wall = new freewall(plugin.element);
            var maxPosSize = _getMaxPossibleSize($(plugin.element), options);
            var gridWidth = maxPosSize;

            plugin.wall.reset({
                    selector: '.imgrid-thumbnail',
                    keepOrder: false,
                    animate: options.thumbAnimation,
                    cellW: function (width) {
                        gridWidth = width;
                        if (width > maxPosSize) {
                            return maxPosSize;
                        } else {
                            return width;
                        }
                    },
                    cellH: function () {
                        if (gridWidth > maxPosSize) {
                            return maxPosSize;
                        } else {
                            return gridWidth;
                        }
                    },
                    gutterX: options.thumbMargin,
                    gutterY: options.thumbMargin,
                    delay: 0,
                    onResize: function () {
                        plugin.wall.refresh();
                    },
                    onComplete: _onComplete(plugin),
                    onBlockFinish: function (item) {
                        _onBlockFinish(plugin, item, options);
                    }
                }
            );
            plugin.wall.fitWidth();
        },
        fluid: function (plugin, options) {
            plugin.wall = new freewall(plugin.element);
            var maxPosSize = _getMaxPossibleSize($(plugin.element), options);

            plugin.wall.reset({
                    selector: '.imgrid-thumbnail',
                    keepOrder: false,
                    animate: options.thumbAnimation,
                    cellW: 20,
                    cellH: maxPosSize,
                    gutterX: options.thumbMargin,
                    gutterY: options.thumbMargin,
                    delay: 0,
                    onResize: function () {
                        plugin.wall.refresh();
                    },
                    onComplete: _onComplete(plugin),
                    onBlockFinish: function (item) {
                        _onBlockFinish(plugin, item, options);
                    }
                }
            );
            plugin.wall.fitWidth();
        },
        masonry: function (plugin, options) {
            plugin.wall = new freewall(plugin.element);
            var maxPosSize = _getMaxPossibleSize($(plugin.element), options);

            plugin.wall.reset({
                    selector: '.imgrid-thumbnail',
                    keepOrder: false,
                    animate: options.thumbAnimation,
                    cellW: maxPosSize,
                    cellH: 'auto',
                    gutterX: options.thumbMargin,
                    gutterY: options.thumbMargin,
                    delay: 50,
                    onResize: function () {
                        plugin.wall.refresh();
                    },
                    onComplete: _onComplete(plugin),
                    onBlockFinish: function (item) {
                        _onBlockFinish(plugin, item, options);
                    }
                }
            );
            plugin.wall.fitWidth();
        },
        fit: function (plugin, options) {
            plugin.wall = new freewall(plugin.element);
            var maxPosSize = _getMaxPossibleSize($(plugin.element), options);

            plugin.wall.reset({
                    selector: '.imgrid-thumbnail',
                    animate: options.thumbAnimation,
                    cellW: maxPosSize / 2,
                    cellH: maxPosSize / 2,
                    gutterX: options.thumbMargin,
                    gutterY: options.thumbMargin,
                    delay: 0,
                    onResize: function () {
                        plugin.wall.refresh(
                            parseInt($(plugin.element).css('width'), 10),
                            parseInt($(plugin.element).css('height'), 10)
                        );
                    },
                    onComplete: _onComplete(plugin),
                    onBlockFinish: function (item) {
                        _onBlockFinish(plugin, item, options);
                    }
                }
            );
            plugin.wall.fitZone(
                parseInt($(plugin.element).css('width'), 10),
                parseInt($(plugin.element).css('height'), 10)
            );
        }
    };


    // Public Methods
    // ==============

    Plugin.prototype.init = function () {
        var plugin = this;

        _addLoader(plugin, 'top');

        $(plugin.element).imagesLoaded(function () {
            _domSetup($(plugin.element), plugin.options);
            _layout[plugin.options.gridLayout](plugin, plugin.options);
            if (plugin.options.thumbLightbox) {
                _lightBox(plugin, plugin.options);
            }

        });

    };

    Plugin.prototype.filter = function (filter) {
        if (filter && filter !== 'all') {
            this.filtered = '.' + filter;
            this.wall.filter('.' + filter);
        } else {
            this.wall.unFilter();
            this.filtered = false;
        }
    };

    Plugin.prototype.addMore = function (html) {
        var plugin = this;
        //plugin.loaded = false;
        var maxSize = _getMaxPossibleSize($(plugin.element), plugin.options) * 0.9;
        var jqObj = $('<div/>').html(html).css('opacity', 0).appendTo('body');
        var $thumb = jqObj.find('figure');

        if (!$thumb.hasClass('imgrid-thumbnail')) {
            $thumb.addClass('imgrid-thumbnail effect-' + plugin.options.thumbHoverEffect);

            if (plugin.options.gridAnimation === false) {
                $thumb.addClass('imgrid-animated');
            }
        }

        _thumbSetup($thumb, plugin.options, maxSize, $(plugin.element));

        _addLoader(plugin, 'bottom');

        jqObj.imagesLoaded(function () {
            var l = $thumb.length;
            plugin.addedCount = l;

            $thumb.each(function (i, item) {
                var $img = $(item).find('img');
                $img.attr('data-original-width', $img.width()).attr('data-original-height', $img.height());
                plugin.wall.appendBlock(this.outerHTML);
                if (i === l - 1) {
                    jqObj.remove();
                    //If imGrid isn't animated then call filter function here
                    if (plugin.options.gridAnimation === false) {
                        plugin.wall.filter(plugin.filtered); //Call filter function if the item is filtered
                    }

                    _onComplete(plugin);
                }
            });
        });


    };

    Plugin.prototype.resizeCaption = function (settings) {
        var maxFontSize = settings.maxFontSize;
        var widthToHide = settings.widthToHide;

        var plugin = this;
        var fontRatio = maxFontSize / $(plugin.element).width();

        $(plugin.element).find('figure figcaption').each(function () {
            var elWidth = _getMaxPossibleSize($(plugin.element), plugin.options);
            if (elWidth < widthToHide) {
                $(this).find('h2').css('display', 'none');
                $(this).find('p').css('display', 'none');
            } else {
                $(this)
                    .css('font-size', elWidth * fontRatio + 'em');
                $(this).find('h2').css('display', '');
                $(this).find('p').css('display', '');
            }
        });
    };

    Plugin.prototype.hoverEffect = function (effect) {
        var plugin = this;
        if (effect) {
            $(plugin.element).find('figure').removeClass('effect-' + plugin.options.thumbHoverEffect).addClass('effect-' + effect);
            plugin.options.thumbHoverEffect = effect;
        } else {
            return plugin.options.thumbHoverEffect;
        }
    };

    Plugin.prototype.isLoaded = function () {
        return (this.loaded === true && this.addedCount === 0);
    };

    Plugin.prototype.destroy = function () {
        this.wall = {};
        $(this.e_original).insertBefore($(this.element));
        $(this.element).remove();
    };


    // Plugin Definition
    // =================

    $.fn[pluginName] = function (options) {
        var args = arguments;

        // Is the first parameter an object (options), or was omitted,
        // instantiate a new instance of the plugin.
        if (options === undefined || typeof options === 'object') {
            return this.each(function () {

                // Only allow the plugin to be instantiated once,
                // so we check that the element has no plugin instantiation yet
                if (!$.data(this, 'plugin_' + pluginName)) {

                    // if it has no instance, create a new one,
                    // pass options to our plugin constructor,
                    // and store the plugin instance
                    // in the elements jQuery data object.
                    $.data(this, 'plugin_' + pluginName, new Plugin(this, options));
                }
            });

            // If the first parameter is a string and it doesn't start
            // with an underscore or "contains" the `init`-function,
            // treat this as a call to a public method.
        } else if (typeof options === 'string' && options[0] !== '_' && options !== 'init') {

            // Cache the method call
            // to make it possible
            // to return a value
            var returns;

            this.each(function () {
                var instance = $.data(this, 'plugin_' + pluginName);

                // Tests that there's already a plugin-instance
                // and checks that the requested public method exists
                if (instance instanceof Plugin && typeof instance[options] === 'function') {

                    // Call the method of our plugin instance,
                    // and pass it the supplied arguments.
                    returns = instance[options].apply(instance, Array.prototype.slice.call(args, 1));
                }

                // Allow instances to be destroyed via the 'destroy' method
                if (options === 'destroy') {
                    $.data(this, 'plugin_' + pluginName, null);
                }
            });

            // If the earlier cached method
            // gives a value back return the value,
            // otherwise return this to preserve chainability.
            return returns !== undefined ? returns : this;
        }
    };


})
(jQuery, window, document);

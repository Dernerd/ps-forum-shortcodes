/*global tinymce */
(function() {

    /**
     * Check is empty.
     *
     * @param  {string} value
     * @return {bool}
     */
    function psfShortcodesIsEmpty(value) {
        value = value.toString();

        if (0 !== value.length) {
            return false;
        }

        return true;
    }

    /**
     * Add the shortcodes downdown.
     */
    tinymce.PluginManager.add('psforum_shortcodes', function(editor) {
        var ed = tinymce.activeEditor;
        editor.addButton('psforum_shortcodes', {
            text: ed.getLang('psforum_shortcodes.shortcode_title'),
            title: ed.getLang('psforum_shortcodes.shortcode_title'),
            icon: 'psforum-shortcodes',
            type: 'menubutton',
            menu: [{
                    text: ed.getLang('psforum_shortcodes.forums'),
                    menu: [{
                            text: ed.getLang('psforum_shortcodes.forum_index'),
                            onclick: function() {
                                editor.insertContent('[psf-forum-index]');
                            }
                        },
                        {
                            text: ed.getLang('psforum_shortcodes.forum_form'),
                            onclick: function() {
                                editor.insertContent('[psf-forum-form]');
                            }
                        },
                        {
                            text: ed.getLang('psforum_shortcodes.single_forum'),
                            onclick: function() {
                                editor.windowManager.open({
                                    title: ed.getLang('psforum_shortcodes.single_forum'),
                                    body: [{
                                        type: 'textbox',
                                        name: 'id',
                                        label: ed.getLang('psforum_shortcodes.forum_id')
                                    }],
                                    onsubmit: function(e) {
                                        var id = psfShortcodesIsEmpty(e.data.id) ? '' : ' id="' + e.data.id + '"';

                                        if (!psfShortcodesIsEmpty(e.data.id)) {
                                            editor.insertContent('[psf-single-forum ' + id + ']');
                                        } else {
                                            editor.windowManager.alert(ed.getLang('psforum_shortcodes.need_id'));
                                        }
                                    }
                                });
                            }
                        }
                    ]
                }, {
                    text: ed.getLang('psforum_shortcodes.topics'),
                    menu: [{
                            text: ed.getLang('psforum_shortcodes.topic_index'),
                            onclick: function() {
                                editor.insertContent('[psf-topic-index]');
                            }
                        },
                        {
                            text: ed.getLang('psforum_shortcodes.topic_form'),
                            onclick: function() {
                                editor.insertContent('[psf-topic-form]');
                            }
                        },
                        {
                            text: ed.getLang('psforum_shortcodes.forum_topic_form'),
                            onclick: function() {
                                editor.windowManager.open({
                                    title: ed.getLang('psforum_shortcodes.forum_topic_form'),
                                    body: [{
                                        type: 'textbox',
                                        name: 'id',
                                        label: ed.getLang('psforum_shortcodes.forum_id')
                                    }],
                                    onsubmit: function(e) {
                                        var id = psfShortcodesIsEmpty(e.data.id) ? '' : ' forum_id="' + e.data.id + '"';

                                        if (!psfShortcodesIsEmpty(e.data.id)) {
                                            editor.insertContent('[psf-topic-form ' + id + ']');
                                        } else {
                                            editor.windowManager.alert(ed.getLang('psforum_shortcodes.need_id'));
                                        }
                                    }
                                });
                            }
                        },
                        {
                            text: ed.getLang('psforum_shortcodes.single_topic'),
                            onclick: function() {
                                editor.windowManager.open({
                                    title: ed.getLang('psforum_shortcodes.single_topic'),
                                    body: [{
                                        type: 'textbox',
                                        name: 'id',
                                        label: ed.getLang('psforum_shortcodes.topic_id')
                                    }],
                                    onsubmit: function(e) {
                                        var id = psfShortcodesIsEmpty(e.data.id) ? '' : ' id="' + e.data.id + '"';

                                        if (!psfShortcodesIsEmpty(e.data.id)) {
                                            editor.insertContent('[psf-single-topic ' + id + ']');
                                        } else {
                                            editor.windowManager.alert(ed.getLang('psforum_shortcodes.need_id'));
                                        }
                                    }
                                });
                            }
                        }
                    ]
                }, {
                    text: ed.getLang('psforum_shortcodes.replies'),
                    menu: [{
                            text: ed.getLang('psforum_shortcodes.reply_form'),
                            onclick: function() {
                                editor.insertContent('[psf-reply-form]');
                            }
                        },
                        {
                            text: ed.getLang('psforum_shortcodes.single_reply'),
                            onclick: function() {
                                editor.windowManager.open({
                                    title: ed.getLang('psforum_shortcodes.single_reply'),
                                    body: [{
                                        type: 'textbox',
                                        name: 'id',
                                        label: ed.getLang('psforum_shortcodes.reply_id')
                                    }],
                                    onsubmit: function(e) {
                                        var id = psfShortcodesIsEmpty(e.data.id) ? '' : ' id="' + e.data.id + '"';

                                        if (!psfShortcodesIsEmpty(e.data.id)) {
                                            editor.insertContent('[psf-single-reply ' + id + ']');
                                        } else {
                                            editor.windowManager.alert(ed.getLang('psforum_shortcodes.need_id'));
                                        }
                                    }
                                });
                            }
                        }
                    ]
                }, {
                    text: ed.getLang('psforum_shortcodes.topic_tags'),
                    menu: [{
                            text: ed.getLang('psforum_shortcodes.display_topic_tags'),
                            onclick: function() {
                                editor.insertContent('[psf-topic-tags]');
                            }
                        },
                        {
                            text: ed.getLang('psforum_shortcodes.single_tag'),
                            onclick: function() {
                                editor.windowManager.open({
                                    title: ed.getLang('psforum_shortcodes.single_tag'),
                                    body: [{
                                        type: 'textbox',
                                        name: 'id',
                                        label: ed.getLang('psforum_shortcodes.tag_id')
                                    }],
                                    onsubmit: function(e) {
                                        var id = psfShortcodesIsEmpty(e.data.id) ? '' : ' id="' + e.data.id + '"';

                                        if (!psfShortcodesIsEmpty(e.data.id)) {
                                            editor.insertContent('[psf-single-tag ' + id + ']');
                                        } else {
                                            editor.windowManager.alert(ed.getLang('psforum_shortcodes.need_id'));
                                        }
                                    }
                                });
                            }
                        }
                    ]
                }, {
                    text: ed.getLang('psforum_shortcodes.views'),
                    menu: [{
                            text: ed.getLang('psforum_shortcodes.popular'),
                            onclick: function() {
                                editor.insertContent('[psf-single-view id="popular"]');
                            }
                        },
                        {
                            text: ed.getLang('psforum_shortcodes.no_replies'),
                            onclick: function() {
                                editor.insertContent('[psf-single-view id="no-replies"]');
                            }
                        }
                    ]
                }, {
                    text: ed.getLang('psforum_shortcodes.search'),
                    menu: [{
                            text: ed.getLang('psforum_shortcodes.search_input'),
                            onclick: function() {
                                editor.insertContent('[psf-search]');
                            }
                        },
                        {
                            text: ed.getLang('psforum_shortcodes.search_form'),
                            onclick: function() {
                                editor.insertContent('[psf-search-form]');
                            }
                        }
                    ]
                }, {
                    text: ed.getLang('psforum_shortcodes.account'),
                    menu: [{
                            text: ed.getLang('psforum_shortcodes.login'),
                            onclick: function() {
                                editor.insertContent('[psf-login]');
                            }
                        },
                        {
                            text: ed.getLang('psforum_shortcodes.register'),
                            onclick: function() {
                                editor.insertContent('[psf-register]');
                            }
                        },
                        {
                            text: ed.getLang('psforum_shortcodes.lost_pass'),
                            onclick: function() {
                                editor.insertContent('[psf-lost-pass]');
                            }
                        }
                    ]
                },
                {
                    text: ed.getLang('psforum_shortcodes.statistics'),
                    onclick: function() {
                        editor.insertContent('[psf-stats]');
                    }
                }
            ]
        });
    });
})();
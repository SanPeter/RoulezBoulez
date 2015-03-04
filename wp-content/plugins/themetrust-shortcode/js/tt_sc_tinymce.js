(function() {
    tinymce.PluginManager.add('tt_sc_button', function( editor, url ) {
        editor.addButton( 'tt_sc_button', {
            title: 'ThemeTrust Shortcodes',
            type: 'menubutton',
            icon: 'icon themetrust-icon',
            menu: [
                {
                    text: 'Button',
                    value: '[button]',
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Insert Button',
                            body: [{
                                type: 'textbox',
                                name: 'label',
                                label: 'Button Text'
                            },
                            {
                                type: 'textbox',
                                name: 'url',
                                label: 'URL'
                            }],
                            onsubmit: function( e ) {
                                editor.insertContent( '[button label="' + e.data.label + '" url="' + e.data.url + '" color="#eee" target="_blank" ptag=true]' );
                            }
                        });
                    }
                },
                {
                    text: 'Columns',
                    value: 'Columns',
                    onclick: function() {
                        editor.insertContent(this.value());
                    },
                    menu: [
                        {
                            text: 'One-Half',
                            value: 'One-Half',
                            onclick: function(e) {
                                e.stopPropagation();
                                editor.insertContent( '[one_half]Your content goes here...[/one_half]<br />[one_half_last]Your content goes here...[/one_half_last]' );
                            }
                        },
                        {
                            text: 'One-Third',
                            value: 'One-Third',
                            onclick: function(e) {
                                e.stopPropagation();
                                editor.insertContent( '[one_third]Your content goes here...[/one_third]<br />[one_third]Your content goes here...[/one_third]<br />[one_third_last]Your content goes here...[/one_third_last]' );
                            }
                        },
                        {
                            text: 'One-Fourth',
                            value: 'One-Fourth',
                            onclick: function(e) {
                                e.stopPropagation();
                                editor.insertContent( '[one_fourth]Your content goes here...[/one_fourth]<br />[one_fourth]Your content goes here...[/one_fourth]<br />[one_fourth]Your content goes here...[/one_fourth]<br />[one_fourth_last]Your content goes here...[/one_fourth_last]' );
                            }
                        },
                    ]
                },
                {
                    text: 'Slideshow',
                    value: 'Slideshow',
                    onclick: function() {
                        var selected_text = editor.selection.getContent()

                        editor.insertContent( '[slideshow]' + selected_text + '[/slideshow]');
                    }
                },
                {
                    text: 'Tabs',
                    value: 'Tabs',
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Insert Tabs',
                            body: [{
                                type: 'listbox',
                                name: 'type',
                                label: 'Tab Type',
                                'values': [
                                    {text: 'Tab', value: 'tab'},
                                    {text: 'Pill', value: 'pill'},
                                ]
                            },
                            {
                                type: 'listbox',
                                name: 'framing',
                                label: 'Framing',
                                'values': [
                                    {text: 'Framed', value: 'framed'},
                                    {text: 'Unframed', value: 'unframed'},
                                ]
                            }],
                            onsubmit: function( e ) {
                                editor.insertContent( '[tab_group type="' + e.data.type +'" style="' + e.data.framing + '"]<br />[tab title="Tab 1"]Tab 1 content goes here...[/tab]<br />[tab title="Tab 2"]Tab 2 content goes here...[/tab]<br />...<br />[/tab_group]' );
                            }
                        });
                    }
                },
                {
                    text: 'Toggles',
                    value: 'Toggles',
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'Insert Toggles',
                            body: [{
                                type: 'listbox',
                                name: 'type',
                                label: 'Toggle Type',
                                'values': [
                                    {text: 'Panel', value: 'panel'},
                                    {text: 'Accordion', value: 'accordion'},
                                ]
                            },
                                {
                                    type: 'listbox',
                                    name: 'framing',
                                    label: 'Framing',
                                    'values': [
                                        {text: 'Framed', value: 'framed'},
                                        {text: 'Unframed', value: 'unframed'},
                                    ]
                                }],
                            onsubmit: function( e ) {
                                editor.insertContent( '[toggle_group type="' + e.data.type +'" style="' + e.data.framing + '"]<br />[toggle title="Toggle 1"]Toggle 1 content goes here...[/toggle]<br />[toggle title="Toggle 2"]Toggle 2 content goes here...[/toggle]<br />...<br />[/toggle_group]' );
                            }
                        });
                    }
                }
            ]
        });
    });
})();
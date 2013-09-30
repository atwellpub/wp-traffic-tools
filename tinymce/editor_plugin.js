(function() {
	// Load plugin specific language pack
	tinymce.PluginManager.requireLangPack('cloakme');
	
	tinymce.create('tinymce.plugins.cloakme', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {
			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');

			ed.addCommand('mcecloakme', function() {
				ed.windowManager.open({
					file : url + '/window.php',
					width : 700 + ed.getLang('cloakme.delta_width', 0),
					height : 500 + ed.getLang('cloakme.delta_height', 0),
					inline : 1
				}, {
					plugin_url : url // Plugin absolute URL
				});
			});

			// Register example button
			ed.addButton('cloakme', {
				title : 'cloakme.desc',
				cmd : 'mcecloakme',
				image : url + '/cloakme.gif'
			});
			
			 ed.onNodeChange.add(function(ed, cm, n) {
                cm.get( 'cloakme' ).setDisabled( ed.selection.isCollapsed() );
            });

		},

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
					longname  : 'cloakme',
					author 	  : 'Hudson Atwell',
					authorurl : 'http://www.blogsense-wp.com',
					infourl   : 'http://www.blogsense-wp.com',
					version   : "1.0"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('cloakme', tinymce.plugins.cloakme);
})();

jQuery(document).ready( function(){
  jQuery('#wiscoFilter').change( targeting );
  function targeting(){// for selecting the target
    var target = jQuery(this).children(':selected');
    target = jQuery(target).val();

    jQuery('.sectionSwipe').addClass('disableSection');
    jQuery('#'+target+'Section').removeClass('disableSection');
  }
  targeting();
  jQuery('#connectedForm').submit( function(){return false;} );
  jQuery('#connectedForm input, #connectedForm select').change( generateShortcode );
  jQuery('#connectedForm input').keydown( generateShortcode );
  jQuery('#connectedForm input').keypress( generateShortcode );
  jQuery('#connectedForm input').keyup( generateShortcode );
  generateShortcode();
  var shortcode = '[wisco ';
  function generateShortcode(){
    shortcode = '[wisco ';
    var filter = jQuery('#wiscoFilter :selected').val();
    if( filter == 'none' ){
      shortcode = shortcode +'off';
    }
    else if( filter == 'all' ){
      shortcode = shortcode +'on';
    }
    else if ( filter == 'allowedRoles' ) {
      var liste = new Array();
      jQuery('#allowedRolesSection :checked').each( function(){
        liste.push( jQuery(this).val() );
      } );
      liste = liste.join(',');
      if( liste != '' ){
        shortcode = shortcode + 'on="' + liste + '"';
      }
      else {
        shortcode = shortcode +'on';
      }
    }
    else if ( filter == 'disallowRoles' ) {
      var liste = new Array();
      jQuery('#disallowRolesSection :checked').each( function(){
        liste.push( '!'+jQuery(this).val() );
      } );
      liste = liste.join(',');
      if( liste != '' ){
        shortcode = shortcode + 'on="' + liste + '"';
      }
      else {
        shortcode = shortcode +'on';
      }
    }
    else if ( filter == 'ids' ) {
      var liste = jQuery('#allowIds').val();
      if( liste != '' ){
        shortcode = shortcode + 'id="' + liste + '"';
      }
      else {
        shortcode = shortcode +'on';
      }
    }
    shortcode = shortcode+']';
    jQuery('#shortcodeResult').html(shortcode+' ... [/wisco]');
  }

  jQuery('#popDatas input[type=button]').on('click' , function(){
    var tgt = this.getAttribute('id');

    var selection = tinymce.EditorManager.activeEditor.selection.getContent();
    tinymce.EditorManager.activeEditor.selection.setContent('[wishow '+tgt+']');
    jQuery('#popInBG.azedPopinBG.azedGlobal').fadeOut(200);
    jQuery('#popDatas.azedPopin.azedGlobal').fadeOut(200);
    jQuery('html').removeClass('overflow');
  } );
  jQuery('#popAccess.azedGlobal.azedPopin .btnPlace #wiscoInserter').click( function(){
    var selection = tinymce.EditorManager.activeEditor.selection.getContent();
    tinymce.EditorManager.activeEditor.selection.setContent(shortcode+selection+'[/wisco]');
    jQuery('#popInBG.azedPopinBG.azedGlobal').fadeOut(200);
    jQuery('#popAccess.azedPopin.azedGlobal').fadeOut(200);
    jQuery('html').removeClass('overflow');
  } );
  jQuery('#popInBG.azedPopinBG.azedGlobal').click( function(){
    jQuery('#popAccess.azedPopin.azedGlobal').fadeOut(200);
    jQuery('#popDatas.azedPopin.azedGlobal').fadeOut(200);
    jQuery('#popInBG.azedPopinBG.azedGlobal').fadeOut(200);
    jQuery('html').removeClass('overflow');
  } );
  jQuery('#popAccess.azedPopin.azedGlobal,#popDatas.azedPopin.azedGlobal').on('click' , function(e){e.stopPropagation();} );
  jQuery('#wisco_shortcode_button').click( function(){
    // var selection = tinymce.EditorManager.activeEditor.selection.getContent();
    // tinymce.EditorManager.activeEditor.selection.setContent('[wisco on]'+selection+'[/wisco]');
    jQuery('#popAccess.azedPopin.azedGlobal').fadeIn(200);
    jQuery('#popInBG.azedPopinBG.azedGlobal').fadeIn(200);
    jQuery('html').addClass('overflow');
    return false;
  } );
  jQuery('#wishow_shortcode_button').click( function(){
    // var selection = tinymce.EditorManager.activeEditor.selection.getContent();
    // tinymce.EditorManager.activeEditor.selection.setContent('[wisco on]'+selection+'[/wisco]');
    jQuery('#popDatas.azedPopin.azedGlobal').fadeIn(200);
    jQuery('#popInBG.azedPopinBG.azedGlobal').fadeIn(200);
    jQuery('html').addClass('overflow');
    return false;
  } );


} );

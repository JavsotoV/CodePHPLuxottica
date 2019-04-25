// @require @packageOverrides
Ext.Loader.setConfig({
    enabled: true
});


Ext.application({
     appFolder: '../../../../luxottica/app/luxottica',
    appProperty: 'luxottica',
    controllers: [
        'gmo.security.segsistema.ctrMain',
        'gmo.security.segmenu.ctrMtto',
        'gmo.security.segmenuopcion.ctrMtto'
    ],
    name: 'luxottica',

    launch: function() {
        Ext.create('luxottica.view.gmo.security.segsistema.vpmain');
    }

});

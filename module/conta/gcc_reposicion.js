// @require @packageOverrides
Ext.Loader.setConfig({
    enabled: true
});


Ext.application({
    appFolder: '../../../../luxottica/app/luxottica',
    appProperty: 'luxottica',
    controllers: [
        'gmo.gcc.reposicion.ctrMain',
        'gmo.gcc.reposicion.ctrMtto'
    ],
    name: 'luxottica',

    launch: function() {
        Ext.create('luxottica.view.gmo.gcc.reposicion.vpmain', {renderTo: Ext.getBody()});
    }

});

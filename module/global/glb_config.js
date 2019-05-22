// @require @packageOverrides
Ext.Loader.setConfig({
    enabled: true
});


Ext.application({
    appFolder: '../../../../luxottica/app/luxottica',
    appProperty: 'luxottica',
    controllers: [
      'gmo.global.glbconfig.ctrMain',
      'gmo.global.glbconfig.ctrMtto',
      'gmo.global.glbubigeo.ctrlstubigeo'
    ],
    name: 'luxottica',
        
    launch: function() {
        Ext.create('luxottica.view.gmo.global.glbconfig.vpmain', {renderTo: Ext.getBody()});
    }

});

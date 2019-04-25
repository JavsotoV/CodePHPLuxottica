// @require @packageOverrides
Ext.Loader.setConfig({
    enabled: true
});


Ext.application({
    appFolder: '../../../../luxottica/app/luxottica',
    appProperty: 'luxottica',
    controllers: [
        'gmo.legal.gcaconsulta.ctrMainmacro',
        'gmo.legal.gcaconsulta.ctrMttomacro',
        'gmo.legal.gcacontrato.ctrMain',
        'gmo.legal.gcacontrato.crtMtto',
        'gmo.global.glbubigeo.ctrlstubigeo'
    ],
    name: 'luxottica',

    launch: function() {
        Ext.create('luxottica.view.gmo.legal.gcaconsulta.vpgcamacro');
    }
});

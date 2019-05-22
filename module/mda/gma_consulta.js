// @require @packageOverrides
Ext.Loader.setConfig({
    enabled: true
});


Ext.application({
    appFolder: '../../../../luxottica/app/luxottica',
    appProperty: 'luxottica',
    controllers: [
        'gmo.gma.ticket.ctrMtto',
        'gmo.gma.binary.ctrPreview',
        'gmo.global.utiles.ctrfuncion',
        'gmo.gma.ticketdet.ctrlistado',
        'gmo.gma.consulta.ctrMain',
        'gmo.gma.message.ctrMtto'
    ],
    name: 'luxottica',

    launch: function() {
        Ext.create('luxottica.view.gmo.gma.consulta.vpmain');
    }

});

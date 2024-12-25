/// <reference path="../pb_data/types.d.ts" />
migrate((app) => {
  const collection = app.findCollectionByNameOrId("pbc_3728844674")

  // remove field
  collection.fields.removeById("number2245608546")

  return app.save(collection)
}, (app) => {
  const collection = app.findCollectionByNameOrId("pbc_3728844674")

  // add field
  collection.fields.addAt(3, new Field({
    "hidden": false,
    "id": "number2245608546",
    "max": null,
    "min": null,
    "name": "count",
    "onlyInt": true,
    "presentable": false,
    "required": true,
    "system": false,
    "type": "number"
  }))

  return app.save(collection)
})

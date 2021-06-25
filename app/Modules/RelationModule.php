<?php

namespace App\Modules;

class RelationModule
{
    /**
     * Create relation between two models in file model file
     * @param appSlug Slug of the Application
     * @param modelName String Name of the model
     * @param fieldName String of the field name
     * @param collectionToRelateTableName the table to relate to
     */
    public function createRelation($appSlug, $modelName, $fieldName, $collectionToRelateTableName)
    {
        try {
            // if the relations doesn't exist will create one
            if (!$this->containsRelation($appSlug, $modelName, $fieldName)) {
                /**
                 * Write the relation in the model
                 */
                $pathToModel = app_path() . "/Models/ApplicationsModels/$appSlug/$modelName.php";
                $linesOfTheModel = file(app_path() . "/Models/ApplicationsModels/$appSlug/$modelName.php");
                $search      = "    //end custom relations from cms";
                $relationsMethodsString = '';
                $relationsMethodsString .= "public function $fieldName(){ ";
                $relationsMethodsString .= 'return $this->hasMany(' . $modelName . '::class, ' . '"id"' . ', "' . $collectionToRelateTableName . '_id"' . ');';
                $relationsMethodsString .= "}";

                foreach ($linesOfTheModel as $key => $value) {
                    if (str_contains($value, $search)) {
                        $linesOfTheModel[($key - 1)] = "\n$relationsMethodsString\n";
                    }
                }
                file_put_contents($pathToModel, implode('', $linesOfTheModel));
                return ['status' => 200, 'message' => "Relação criada $fieldName e $modelName"];
            } else {
                return ['status' => 500, 'message' => 'Relação já existente'];
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Updates some relation, changing the name of it and the table
     */
    public function updateRelation($appSlug, $modelName, $fieldName, $collectionToRelateTableName, $newFieldName, $newCollectionToRelateTableName)
    {
        // Check if the relation exists e the new one does not exist
        $pathToModel = app_path() . "/Models/ApplicationsModels/$appSlug/$modelName.php";
        $linesOfTheModel = file(app_path() . "/Models/ApplicationsModels/$appSlug/$modelName.php");
        $search = "$fieldName";
        $relationsMethodsString = '';
        if ($this->containsRelation($appSlug, $modelName, $fieldName) && !$this->containsRelation($appSlug, $modelName, $newFieldName)) {
            foreach ($linesOfTheModel as $key => $value) {
                if (str_contains($value, $search)) {
                    dd($value);
                    $linesOfTheModel[($key - 1)] = "\n$relationsMethodsString\n";
                }
            }
            file_put_contents($pathToModel, implode('', $linesOfTheModel));
            return ['status' => 200, 'message' => "Nova relação criada $newFieldName e $modelName"];
        } else {
            return ['status' => 500, 'message' => 'Relação existente não encontrada ou nova relação já existe'];
        }
    }
    /**
     * Verify if given model contains a given relation already, serves to not repeat methods...
     * @param appSlug Slug of the Application
     * @param modelName String Name of the model
     * @param fieldName function given by the fieldName in the createRelation method
     */
    public function containsRelation($appSlug, $modelName, $fieldName)
    {
        $linesOfTheModel = file(app_path() . "/Models/ApplicationsModels/$appSlug/$modelName.php");
        $search = "public function $fieldName(){";
        foreach ($linesOfTheModel as $key => $value) {
            if (str_contains($value, $search)) {
                return true;
            }
        }
        return false;
    }
}

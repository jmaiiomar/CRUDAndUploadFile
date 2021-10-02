# CRUDAndUploadFile
 
this repo conatines methode allow user uplaod file using Angular and symfony4.4  and CRUD for an entitie


```Symfony

 /**
     * @Route("/upload", name="uploadimag", methods={"GET","POST"})
     */
    public function upload(Request $request): Response
    {
        $folderPath = "uploads/";
        $image_parts = explode(";base64,", $request->get("image"));
      
        $image_type_aux = explode("image/", $image_parts[0]);
         
        $image_type = $image_type_aux[1];
       
        $image_base64 = base64_decode($image_parts[1]);
        
        $file = $folderPath.uniqid() . '.png';
        
        file_put_contents($file, $image_base64);
        $imagename= substr($file, 8, strlen($file));;
        
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($imagename);
        return new JsonResponse( $formatted);
    }
```

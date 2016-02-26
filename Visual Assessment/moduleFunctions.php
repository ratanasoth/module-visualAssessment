<?php
/*
Gibbon, Flexible & Open School System
Copyright (C) 2010, Ross Parker

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/


function getChildren($rowAll, $visualAssessmentTermIDParent, $level=0, $studentResults=NULL) {
	$childrenCount=0 ;
	$json="" ;
	$jsonInt="" ;
	
	$json=$json=",\"children\": [" ;
	
	foreach ($rowAll AS $row) {
		if ($row["visualAssessmentTermIDParent"]==$visualAssessmentTermIDParent) {
			$childrenCount++ ;
			$title=addslashes($row["term"]) ;
			if ($row["description"]!="") {
				$title=addslashes($row["term"]) . " - " . addslashes($row["description"]) ;
			}
			$jsonInt.="{\"name\": \"" . $row["term"] . "\", \"class\": \"" . $row["visualAssessmentTermID"] . "\", \"level\": \"" . $level . "\", \"title\": \"" . $title . "\"" ;
			if ($studentResults!=NULL) {
				foreach ($studentResults AS $studentResult) {
					if ($studentResult["visualAssessmentTermID"]==$row["visualAssessmentTermID"]) {
						$jsonInt.=", \"attainment\": \"" . "attainment" . $studentResult["attainment"] . "\"" ;
						break ;
					}
				}
			}
			
			$jsonInt.=getChildren($rowAll, $row["visualAssessmentTermID"], ($level+1), $studentResults) ;
			$jsonInt.="}," ;
		}
	}
	
	if ($jsonInt!="") {
		$jsonInt=substr($jsonInt, 0, -1) ;
	}
	$json.=$jsonInt ;
	$json.="]" ;		
	
	return $json ;
}
			
?>

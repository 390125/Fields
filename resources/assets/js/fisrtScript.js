$(document).ready(
    function(){
        if( navigator.geolocation ){
            // 現在位置を取得する
            navigator.geolocation.getCurrentPosition(
                // [第1引数] 取得に成功した場合の関数
                function( position )
                {
                    // 取得したデータの整理
                    var data = position.coords ;

                    // データの整理
                    var lat = data.latitude ;
                    var lng = data.longitude ;

                    // hidden値に緯度・経度を設定
                    document.getElementById("lat").value = lat;
                    document.getElementById("lng").value = lng;
                } ,
                // [第2引数] 取得に失敗した場合の関数
                function( error )
                {
                    // エラーコード(error.code)の番号
                    // 0:UNKNOWN_ERROR				原因不明のエラー
                    // 1:PERMISSION_DENIED			利用者が位置情報の取得を許可しなかった
                    // 2:POSITION_UNAVAILABLE		電波状況などで位置情報が取得できなかった
                    // 3:TIMEOUT					位置情報の取得に時間がかかり過ぎた…

                    // エラー番号に対応したメッセージ
                    var errorInfo = [
                        "原因不明のエラーが発生しました…。" ,
                        "位置情報の取得が許可されませんでした…。" ,
                        "電波状況などで位置情報が取得できませんでした…。" ,
                        "位置情報の取得に時間がかかり過ぎてタイムアウトしました…。"
                    ] ;

                    // エラー番号
                    var errorNo = error.code ;
                    // エラーメッセージ
                    var errorMessage = "[エラー番号: " + errorNo + "]\n" + errorInfo[ errorNo ] ;
                    // アラート表示
                    alert( errorMessage ) ;
                } ,
                // [第3引数] オプション
                {
                    "enableHighAccuracy": false,
                    "timeout": 8000,
                    "maximumAge": 2000,
                }
            ) ;
        }else{
            // 現在位置を取得できない場合の処理
            alert( "あなたの端末では、現在位置を取得できません。" ) ;
        }
    }
);

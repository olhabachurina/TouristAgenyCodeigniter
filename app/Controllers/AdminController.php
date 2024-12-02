<?php

namespace App\Controllers;

use App\Models\CountriesModel;
use App\Models\CitiesModel;
use App\Models\HotelsModel;
use App\Models\ImageModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class AdminController extends BaseController
{
    public function index()
    {
        $countriesModel = new CountriesModel();
        $citiesModel = new CitiesModel();
        $hotelsModel = new HotelsModel();
        $imageModel = new ImageModel();

        $data = [
            'countries' => $countriesModel->findAll(),
            'cities' => $citiesModel->getCitiesWithCountries(),
            'hotels' => $hotelsModel->getHotelsWithCities(),
            'images' => $imageModel->getImagesWithHotels(),
            'comments' => [] // Если есть комментарии, добавьте их здесь
        ];



        return view('admin/index', $data);
    }

    public function addCountry()
    {
        $countryName = $this->request->getPost('country');
        if (!empty($countryName)) {
            $countriesModel = new CountriesModel();
            $countriesModel->insert(['country' => $countryName]);
            session()->setFlashdata('success', 'Country added successfully.');
        } else {
            session()->setFlashdata('error', 'Failed to add country. Name cannot be empty.');
        }
        return redirect()->to('/admin');
    }

    public function deleteCountry()
    {
        $countryId = $this->request->getPost('id');
        if (!empty($countryId)) {
            $countriesModel = new CountriesModel();
            if ($countriesModel->delete($countryId)) {
                return redirect()->to('/admin')->with('success', 'Country deleted successfully.');
            } else {
                return redirect()->to('/admin')->with('error', 'Failed to delete country.');
            }
        }
        return redirect()->to('/admin')->with('error', 'Invalid country ID.');
    }

    public function addCity()
    {
        $cityName = $this->request->getPost('city');
        $countryId = $this->request->getPost('country_id');

        if (!empty($cityName) && !empty($countryId)) {
            $citiesModel = new CitiesModel();
            $citiesModel->insert(['city' => $cityName, 'countryid' => $countryId]);
            session()->setFlashdata('success', 'City added successfully.');
        } else {
            session()->setFlashdata('error', 'Failed to add city. All fields are required.');
        }

        return redirect()->to('/admin');
    }

    public function deleteCity()
    {
        $cityId = $this->request->getPost('id');
        if (!empty($cityId)) {
            $citiesModel = new CitiesModel();
            if ($citiesModel->delete($cityId)) {
                return redirect()->to('/admin')->with('success', 'City deleted successfully.');
            } else {
                return redirect()->to('/admin')->with('error', 'Failed to delete city.');
            }
        }
        return redirect()->to('/admin')->with('error', 'Invalid city ID.');
    }

    public function addHotel()
    {
        $hotelName = $this->request->getPost('hotel');
        $cityId = $this->request->getPost('city_id');
        $stars = $this->request->getPost('stars');
        $cost = $this->request->getPost('cost');
        $info = $this->request->getPost('info');

        if (!empty($hotelName) && !empty($cityId) && $stars > 0 && $cost > 0) {
            $hotelsModel = new HotelsModel();
            $citiesModel = new CitiesModel();

            // Получить `countryid`, связанный с `city_id`
            $city = $citiesModel->find($cityId);
            if ($city) {
                $countryId = $city['countryid'];

                $hotelsModel->insert([
                    'hotel' => $hotelName,
                    'cityid' => $cityId,
                    'countryid' => $countryId, // Добавляем `countryid`
                    'stars' => $stars,
                    'cost' => $cost,
                    'info' => $info,
                ]);

                return redirect()->to('/admin')->with('success', 'Hotel added successfully.');
            } else {
                return redirect()->to('/admin')->with('error', 'Invalid city selected.');
            }
        }

        return redirect()->to('/admin')->with('error', 'Please provide valid hotel details.');
    }

    public function deleteHotel()
    {
        $hotelId = $this->request->getPost('id');
        if (!empty($hotelId)) {
            $hotelsModel = new HotelsModel();
            if ($hotelsModel->delete($hotelId)) {
                return redirect()->to('/admin')->with('success', 'Hotel deleted successfully.');
            } else {
                return redirect()->to('/admin')->with('error', 'Failed to delete hotel.');
            }
        }
        return redirect()->to('/admin')->with('error', 'Invalid hotel ID.');
    }

    public function addImage()
    {
        $hotelId = $this->request->getPost('hotel_id');
        $files = $this->request->getFileMultiple('images');

        if ($files && !empty($hotelId)) {
            $imageModel = new ImageModel();
            $uploadPath = ROOTPATH . 'public/uploads/images';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $uploaded = false;

            foreach ($files as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move($uploadPath, $newName);

                    $imageModel->insert([
                        'hotelid' => $hotelId,
                        'imagepath' => 'images/' . $newName,
                    ]);
                    $uploaded = true;
                }
            }

            if ($uploaded) {
                session()->setFlashdata('success', 'Images added successfully.');
            } else {
                session()->setFlashdata('error', 'No valid images were uploaded.');
            }
        } else {
            session()->setFlashdata('error', 'Failed to add images. Please select a hotel and upload images.');
        }

        return redirect()->to('/admin');
    }

    public function deleteImage()
    {
        $imageId = $this->request->getPost('id');
        if (!empty($imageId)) {
            $imageModel = new ImageModel();
            $image = $imageModel->find($imageId);

            if ($image) {
                $filePath = ROOTPATH . 'public/' . $image['imagepath'];
                if (file_exists($filePath)) {
                    unlink($filePath); // Удаляем файл с сервера
                }
                if ($imageModel->delete($imageId)) {
                    return redirect()->to('/admin')->with('success', 'Image deleted successfully.');
                } else {
                    return redirect()->to('/admin')->with('error', 'Failed to delete image record from database.');
                }
            } else {
                return redirect()->to('/admin')->with('error', 'Image not found.');
            }
        }
        return redirect()->to('/admin')->with('error', 'Invalid image ID.');
    }
    public function comments()
    {
        $commentsModel = new CommentsModel();

        try {
            $data['comments'] = $commentsModel->getCommentsWithHotelNames(); // Используем метод из модели

            return view('admin/comments', $data);
        } catch (\Exception $e) {
            log_message('error', '[ERROR] {exception}', ['exception' => $e]);
            return redirect()->back()->with('error', 'Failed to load comments. Please try again later.');
        }
    }

    public function deleteComment()
    {
        $commentId = $this->request->getPost('id');

        if (empty($commentId)) {
            return redirect()->back()->with('error', 'Invalid comment ID.');
        }

        $commentsModel = new CommentsModel();

        try {
            if ($commentsModel->delete($commentId)) {
                return redirect()->to('/admin/comments')->with('success', 'Comment deleted successfully.');
            } else {
                return redirect()->back()->with('error', 'Failed to delete comment. Please try again.');
            }
        } catch (\Exception $e) {
            log_message('error', '[ERROR] {exception}', ['exception' => $e]);
            return redirect()->back()->with('error', 'An unexpected error occurred.');
        }
    }

    public function manageAdmins()
    {
        $userModel = new UserModel(); // Используем модель
        $users = $userModel->findAll(); // Получение всех пользователей
        foreach ($users as &$user) {
            if (!empty($user['avatar'])) {
                $user['avatar_path'] = base_url('uploads/images/Аватарки/' . $user['avatar']);
            } else {
                $user['avatar_path'] = base_url('uploads/images/Аватарки/default-avatar.png'); // Для пользователей без аватарки
            }
        }

        return view('admin/manage_admins', ['users' => $users]); // Передаём пользователей в представление
    }


    public function updateAdmin()
    {
        $userModel = new UserModel();
        $file = $this->request->getFile('file');

        if (!$file->isValid()) {
            return redirect()->back()->with('error', 'Invalid file upload.');
        }

        $userId = $this->request->getPost('userid');
        $fileName = $file->getRandomName();
        $file->move(WRITEPATH . '../public/uploads/images/Аватарки', $fileName);

        $userModel->update($userId, [
            'avatar' => $fileName,
            'roleid' => 1
        ]);

        return redirect()->back()->with('success', 'Administrator updated successfully!');
    }
}
